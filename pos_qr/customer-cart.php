<?php 
session_start();

// Get parameters
$tableNumber = intval($_GET['table'] ?? $_SESSION['table_number'] ?? 1);
$_SESSION['table_number'] = $tableNumber;

// Initialize cart if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];

// Handle cart operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_quantity') {
        $itemId = $_POST['item_id'] ?? '';
        $quantity = intval($_POST['quantity'] ?? 1);
        
        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                if ($quantity <= 0) {
                    // Remove item
                    $cart = array_filter($cart, fn($i) => $i['id'] !== $itemId);
                } else {
                    $item['quantity'] = min($quantity, 20);
                }
                break;
            }
        }
        $_SESSION['cart'] = $cart;
    } 
    elseif ($action === 'remove') {
        $itemId = $_POST['item_id'] ?? '';
        $cart = array_filter($cart, fn($i) => $i['id'] !== $itemId);
        $_SESSION['cart'] = $cart;
    }
    elseif ($action === 'update_notes') {
        $itemId = $_POST['item_id'] ?? '';
        $notes = $_POST['notes'] ?? '';
        
        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                $item['notes'] = $notes;
                break;
            }
        }
        $_SESSION['cart'] = $cart;
    }
    elseif ($action === 'confirm_order') {
        if (count($cart) > 0) {
            // Save order to session
            $_SESSION['current_order'] = [
                'table_number' => $tableNumber,
                'items' => $cart,
                'total_amount' => calculateTotal($cart),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'pending'
            ];
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            header('Location: customer-order-confirmation.php?table=' . $tableNumber);
            exit();
        }
    }
    
    // Return JSON response for AJAX
    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'อัปเดตแล้ว',
            'cartTotal' => calculateTotal($_SESSION['cart'])
        ]);
        exit();
    }
}

// Calculate functions
function calculateTotal($items) {
    return array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
}

function formatCurrency($amount) {
    return number_format($amount, 0);
}

$total = calculateTotal($cart);
$added = $_GET['added'] ?? false;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>ตะกร้า - โต๊ะ <?php echo $tableNumber; ?> | POS Restaurant</title>
    
    <?php include 'partials/head-css.php' ?>
    <link href="assets/css/customer-cart.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Header -->
    <div class="cart-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h2 style="margin: 0; flex: 1; font-size: 1.1rem;">🛒 ตะกร้าสินค้า</h2>
    </div>

    <!-- Content -->
    <div class="cart-content">
        <?php if ($added): ?>
            <div class="info-alert">
                ✓ เพิ่มลงตะกร้าแล้ว
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <!-- Empty cart -->
            <div class="empty-cart">
                <div class="empty-icon">🛒</div>
                <div class="empty-text">ตะกร้าว่างเปล่า</div>
                <a href="customer-menu-list.php?table=<?php echo $tableNumber; ?>" class="continue-shopping">
                    ← เลือกเมนูต่อ
                </a>
            </div>
        <?php else: ?>
            <!-- Cart items -->
            <?php foreach ($cart as $item): ?>
                <div class="cart-item" id="item-<?php echo htmlspecialchars($item['id']); ?>">
                    <div class="cart-item-header">
                        <div class="cart-item-name">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </div>
                        <button class="cart-item-remove" onclick="removeItem('<?php echo $item['id']; ?>')">
                            ✕
                        </button>
                    </div>

                    <div class="cart-item-price">
                        ฿<?php echo formatCurrency($item['price']); ?> × <?php echo $item['quantity']; ?> = <strong>฿<?php echo formatCurrency($item['price'] * $item['quantity']); ?></strong>
                    </div>

                    <div class="cart-item-qty">
                        <span style="color: #666;">จำนวน:</span>
                        <button class="qty-btn" onclick="updateQty('<?php echo $item['id']; ?>', <?php echo $item['quantity'] - 1; ?>)">−</button>
                        <input type="number" class="qty-input" value="<?php echo $item['quantity']; ?>" readonly>
                        <button class="qty-btn" onclick="updateQty('<?php echo $item['id']; ?>', <?php echo $item['quantity'] + 1; ?>)">+</button>
                    </div>

                    <!-- Spicy level badge -->
                    <div class="cart-item-spicy">
                        🌶️ 
                        <?php 
                        $spicyLabels = [
                            'mild' => 'น้อย',
                            'normal' => 'ปกติ',
                            'hot' => 'เผ็ด',
                            'veryHot' => 'เผ็ดมาก'
                        ];
                        echo $spicyLabels[$item['spicy_level']] ?? 'ปกติ';
                        ?>
                    </div>

                    <!-- Notes section -->
                    <div class="cart-item-notes" id="notes-display-<?php echo $item['id']; ?>" 
                         onclick="toggleEditNotes('<?php echo $item['id']; ?>')">
                        <?php if (!empty($item['notes'])): ?>
                            📝 <?php echo htmlspecialchars($item['notes']); ?> (แตะเพื่อแก้ไข)
                        <?php else: ?>
                            <span style="color: #bbb;">แตะเพื่อเพิ่มหมายเหตุ</span>
                        <?php endif; ?>
                    </div>

                    <!-- Edit notes form -->
                    <form class="edit-notes-form" id="notes-form-<?php echo $item['id']; ?>" onsubmit="saveNotes(event, '<?php echo $item['id']; ?>')">
                        <textarea class="notes-textarea" name="notes" placeholder="หมายเหตุพิเศษ..."><?php echo htmlspecialchars($item['notes'] ?? ''); ?></textarea>
                        <div class="notes-actions">
                            <button type="button" class="notes-btn notes-cancel" onclick="toggleEditNotes('<?php echo $item['id']; ?>')">
                                ยกเลิก
                            </button>
                            <button type="submit" class="notes-btn notes-save">
                                บันทึก
                            </button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>

            <!-- Placeholder for cart summary space -->
            <div style="height: 100px;"></div>

        <?php endif; ?>
    </div>

    <!-- Cart summary -->
    <?php if (!empty($cart)): ?>
        <div class="cart-summary">
            <div class="summary-row">
                <span>รวม (<?php echo count($cart); ?> รายการ)</span>
                <span class="total-amount">฿<?php echo formatCurrency($total); ?></span>
            </div>
            
            <form method="POST" id="confirmForm">
                <input type="hidden" name="action" value="confirm_order">
                <button type="submit" class="confirm-btn">
                    ยืนยันการสั่งอาหาร →
                </button>
            </form>
        </div>
    <?php endif; ?>

    <script>
        function updateQty(itemId, newQty) {
            if (newQty <= 0) {
                if (confirm('ต้องการลบรายการนี้จากตะกร้าหรือไม่?')) {
                    removeItem(itemId);
                }
                return;
            }
            
            if (newQty > 20) newQty = 20;
            
            const form = new FormData();
            form.append('action', 'update_quantity');
            form.append('item_id', itemId);
            form.append('quantity', newQty);
            form.append('ajax', '1');
            
            fetch(window.location.href, {
                method: 'POST',
                body: form
            })
            .then(r => r.json())
            .then(data => {
                location.reload();
            })
            .catch(err => console.error('Error:', err));
        }

        function removeItem(itemId) {
            if (confirm('ต้องการลบรายการนี้หรือไม่?')) {
                const form = new FormData();
                form.append('action', 'remove');
                form.append('item_id', itemId);
                
                fetch(window.location.href, {
                    method: 'POST',
                    body: form
                })
                .then(r => r.text())
                .then(() => {
                    document.getElementById('item-' + itemId).style.opacity = '0.5';
                    setTimeout(() => location.reload(), 300);
                });
            }
        }

        function toggleEditNotes(itemId) {
            const display = document.getElementById('notes-display-' + itemId);
            const form = document.getElementById('notes-form-' + itemId);
            
            display.classList.toggle('hidden');
            form.classList.toggle('show');
            
            if (form.classList.contains('show')) {
                form.querySelector('.notes-textarea').focus();
            }
        }

        function saveNotes(e, itemId) {
            e.preventDefault();
            
            const textarea = document.getElementById('notes-form-' + itemId).querySelector('.notes-textarea');
            const notes = textarea.value;
            
            const form = new FormData();
            form.append('action', 'update_notes');
            form.append('item_id', itemId);
            form.append('notes', notes);
            form.append('ajax', '1');
            
            fetch(window.location.href, {
                method: 'POST',
                body: form
            })
            .then(r => r.json())
            .then(data => {
                toggleEditNotes(itemId);
                const display = document.getElementById('notes-display-' + itemId);
                if (notes) {
                    display.innerHTML = '📝 ' + notes.replace(/</g, '&lt;').replace(/>/g, '&gt;') + ' (แตะเพื่อแก้ไข)';
                } else {
                    display.innerHTML = '<span style="color: #bbb;">แตะเพื่อเพิ่มหมายเหตุ</span>';
                }
            })
            .catch(err => console.error('Error:', err));
        }
    </script>
</body>
</html>
