<?php 
session_start();

// Get table number
$tableNumber = intval($_GET['table'] ?? $_SESSION['table_number'] ?? 1);
$_SESSION['table_number'] = $tableNumber;

// Mock order history data - in production, this would come from database
$orderHistory = [
    [
        'id' => 'ORD001',
        'table' => $tableNumber,
        'items' => [
            ['name' => 'ผัดไทย', 'quantity' => 2, 'price' => 60, 'notes' => 'ไม่ใส่ผัก'],
            ['name' => 'ไก่ทอด', 'quantity' => 1, 'price' => 80, 'notes' => '']
        ],
        'total' => 200,
        'status' => 'served',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'served_at' => date('Y-m-d H:i:s', strtotime('-1.5 hours'))
    ],
    [
        'id' => 'ORD002',
        'table' => $tableNumber,
        'items' => [
            ['name' => 'แกงแดง', 'quantity' => 1, 'price' => 90, 'notes' => 'เผ็ดมาก']
        ],
        'total' => 90,
        'status' => 'cooking',
        'created_at' => date('Y-m-d H:i:s', strtotime('-20 minutes')),
        'served_at' => null
    ],
    [
        'id' => 'ORD003',
        'table' => $tableNumber,
        'items' => [
            ['name' => 'ส้มตำ', 'quantity' => 2, 'price' => 50, 'notes' => 'น้อย'],
            ['name' => 'ลาบไก่', 'quantity' => 1, 'price' => 70, 'notes' => '']
        ],
        'total' => 170,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s', strtotime('-5 minutes')),
        'served_at' => null
    ]
];

// Get current order from session if exists
$currentOrder = $_SESSION['current_order'] ?? null;
$allOrders = [];

// Add current order to top
if ($currentOrder && $currentOrder['table_number'] === $tableNumber) {
    $allOrders[] = $currentOrder;
}

// Add history orders
$allOrders = array_merge($allOrders, $orderHistory);

// Filter orders for current table only
$tableOrders = array_filter($allOrders, function($order) use ($tableNumber) {
    return ($order['table_number'] ?? $order['table']) === $tableNumber;
});

// Reverse to show latest first
$tableOrders = array_reverse($tableOrders);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>ประวัติการสั่งอาหาร - โต๊ะ <?php echo $tableNumber; ?> | POS Restaurant</title>
    
    <?php include 'partials/head-css.php' ?>
    <link href="assets/css/customer-order-history.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Header -->
    <div class="history-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h2 style="margin: 0; flex: 1; font-size: 1.1rem;">📋 ประวัติการสั่งอาหาร</h2>
    </div>

    <!-- Content -->
    <div class="history-content">
        <!-- Auto-refresh info -->
        <div class="auto-refresh-info">
            <span class="refresh-dot"></span>
            อัปเดตสถานะอัตโนมัติทุก 10 วินาที
        </div>

        <!-- Current orders -->
        <?php if (!empty($tableOrders)): ?>
            <?php foreach ($tableOrders as $order): ?>
                <div class="order-card" id="order-<?php echo htmlspecialchars($order['id'] ?? uniqid()); ?>">
                    <!-- Header -->
                    <div class="order-header">
                        <div>
                            <div class="order-id">
                                ออเดอร์ #<?php echo htmlspecialchars(substr($order['id'] ?? '', -3)); ?>
                            </div>
                            <div class="order-time">
                                📅 <?php 
                                $timestamp = strtotime($order['created_at']);
                                echo date('H:i', $timestamp) . ' - ' . date('d/m/Y', $timestamp);
                                ?>
                            </div>
                        </div>
                        <div class="order-status <?php echo 'status-' . $order['status']; ?> 
                            <?php echo in_array($order['status'], ['pending', 'cooking']) ? 'status-animation' : ''; ?>">
                            <?php 
                            $statusLabels = [
                                'pending' => '⏳ รอทำ',
                                'cooking' => '👨‍🍳 กำลังทำ',
                                'served' => '✓ เสิร์ฟแล้ว'
                            ];
                            echo $statusLabels[$order['status']] ?? $order['status'];
                            ?>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="order-items">
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="order-item">
                                <div class="item-info">
                                    <div class="item-name">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                        <span style="color: #999; font-weight: normal;"> × <?php echo $item['quantity']; ?></span>
                                    </div>
                                    <?php if (!empty($item['notes'])): ?>
                                        <div class="item-notes">
                                            📝 <?php echo htmlspecialchars($item['notes']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="item-qty-price">
                                    ฿<?php echo number_format($item['price'] * $item['quantity'], 0); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Total -->
                    <div class="order-total">
                        <span class="total-label">รวมทั้งสิ้น</span>
                        <span class="total-amount">฿<?php echo number_format($order['total'], 0); ?></span>
                    </div>

                    <!-- Timeline -->
                    <div class="order-timeline">
                        <div class="timeline-step <?php echo in_array($order['status'], ['cooking', 'served']) ? 'active' : ''; ?>">
                            ✓ ยืนยัน
                        </div>
                        <div class="timeline-step <?php echo in_array($order['status'], ['cooking', 'served']) ? 'active' : ''; ?>">
                            👨‍🍳 ทำ
                        </div>
                        <div class="timeline-step <?php echo $order['status'] === 'served' ? 'active' : ''; ?>">
                            🍽️ เสิร์ฟ
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Empty state -->
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <div class="empty-text">ไม่มีประวัติการสั่งอาหาร</div>
                <a href="customer-menu-list.php?table=<?php echo $tableNumber; ?>" class="order-new-btn">
                    🍔 สั่งอาหารใหม่
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-refresh orders every 10 seconds
        const autoRefresh = setInterval(() => {
            fetch(window.location.href)
                .then(r => r.text())
                .then(html => {
                    // Parse and update the orders section
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');
                    const newContent = newDoc.querySelector('.history-content');
                    
                    if (newContent) {
                        document.querySelector('.history-content').innerHTML = newContent.innerHTML;
                    }
                })
                .catch(err => console.log('Auto-refresh failed:', err));
        }, 10000);

        // Clear interval on page leave
        window.addEventListener('beforeunload', () => {
            clearInterval(autoRefresh);
        });

        // Manual refresh button (can be added to UI)
        function refreshOrders() {
            location.reload();
        }

        // Keyboard shortcut: R to refresh
        document.addEventListener('keyup', (e) => {
            if (e.key === 'r' || e.key === 'R') {
                refreshOrders();
            }
        });
    </script>
</body>
</html>
