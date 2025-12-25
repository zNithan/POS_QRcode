<?php 
session_start();

// Get parameters
$tableNumber = intval($_GET['table'] ?? $_SESSION['table_number'] ?? 1);
$_SESSION['table_number'] = $tableNumber;

// Get current order from session
$currentOrder = $_SESSION['current_order'] ?? null;

// If no order, redirect back
if (!$currentOrder) {
    header('Location: customer-menu-list.php?table=' . $tableNumber);
    exit();
}

// Handle confirmation or cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'confirm') {
        // In production, save order to database here
        // For now, add to order history in session
        if (!isset($_SESSION['order_history'])) {
            $_SESSION['order_history'] = [];
        }
        
        $_SESSION['order_history'][] = [
            'id' => 'ORD' . str_pad(count($_SESSION['order_history']) + 1, 3, '0', STR_PAD_LEFT),
            'table_number' => $tableNumber,
            'items' => $currentOrder['items'],
            'total_amount' => $currentOrder['total_amount'],
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ];
        
        // Clear current order
        unset($_SESSION['current_order']);
        
        // Redirect to order history
        header('Location: customer-order-history.php?table=' . $tableNumber . '&confirmed=1');
        exit();
    } 
    elseif ($action === 'cancel') {
        // Restore cart from order
        $_SESSION['cart'] = $currentOrder['items'];
        unset($_SESSION['current_order']);
        
        header('Location: customer-cart.php?table=' . $tableNumber);
        exit();
    }
}

$total = $currentOrder['total_amount'];
$itemCount = count($currentOrder['items']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>ยืนยันการสั่งอาหาร | POS Restaurant</title>
    
    <?php include 'partials/head-css.php' ?>
    <link href="assets/css/customer-order-confirmation.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Confirmation container -->
    <div class="confirmation-container" id="confirmationContent">
        <div class="success-icon">📋</div>
        
        <h1>ยืนยันการสั่งอาหาร</h1>
        <p class="subtitle">โปรดตรวจสอบรายการก่อนยืนยัน</p>

        <!-- Table info -->
        <div class="table-info-box">
            <div class="table-label">โต๊ะหมายเลข</div>
            <div class="table-number"><?php echo $tableNumber; ?></div>
        </div>

        <!-- Order summary -->
        <div class="order-summary">
            <div class="summary-title">📌 สรุปการสั่งอาหาร</div>
            
            <?php foreach ($currentOrder['items'] as $item): ?>
                <div class="summary-item">
                    <div>
                        <div><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="item-detail">× <?php echo $item['quantity']; ?> จาน</div>
                    </div>
                    <div class="item-price">
                        ฿<?php echo number_format($item['price'] * $item['quantity'], 0); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-label">รวมทั้งสิ้น</div>
            <div class="total-amount">฿<?php echo number_format($total, 0); ?></div>
        </div>

        <!-- Note -->
        <div class="note-section">
            <strong>⏱️ เวลาประมาณ</strong>
            อาหารจะพร้อมเสิร์ฟประมาณ 15-20 นาที
        </div>

        <!-- Buttons -->
        <form method="POST" class="button-group" id="confirmationForm">
            <input type="hidden" name="action" value="confirm" id="actionInput">
            
            <button type="button" class="btn btn-cancel" onclick="cancelOrder()">
                ← ยกเลิก
            </button>
            <button type="submit" class="btn btn-confirm">
                ✓ ยืนยันการสั่ง
            </button>
        </form>
    </div>

    <!-- Loading state -->
    <div class="loading" id="loadingContent">
        <div class="spinner"></div>
        <p style="margin-top: 1rem; color: white; font-weight: 600;">กำลังประมวลผล...</p>
    </div>

    <script>
        function cancelOrder() {
            if (confirm('ต้องการยกเลิกการสั่งอาหารหรือไม่? จะกลับไปที่ตะกร้าสินค้า')) {
                document.getElementById('actionInput').value = 'cancel';
                document.getElementById('confirmationForm').submit();
            }
        }

        // Handle form submission
        document.getElementById('confirmationForm').addEventListener('submit', function(e) {
            // Show loading state
            document.getElementById('confirmationContent').style.display = 'none';
            document.getElementById('loadingContent').style.display = 'block';
            
            // Vibrate
            if (navigator.vibrate) {
                navigator.vibrate([100, 50, 100]);
            }
        });

        // Keyboard shortcut: Enter to confirm
        document.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('confirmationForm').submit();
            }
        });
    </script>
</body>
</html>
