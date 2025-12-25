<?php 
session_start();

// Mock data for menu items - in production, this would come from database
$menuItems = [
    [
        'id' => 1,
        'name' => 'ผัดไทย',
        'nameEn' => 'Pad Thai',
        'price' => 60,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'noodles',
        'available' => true,
        'description' => 'เส้นเล็ก ผัดกลม ด้วยไข่ กุ้งแห้ง ถั่วงอก หอม'
    ],
    [
        'id' => 2,
        'name' => 'ไก่ทอด',
        'nameEn' => 'Fried Chicken',
        'price' => 80,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'chicken',
        'available' => true,
        'description' => 'ไก่ต้นกำลัง ทอดกรอบนอกนุ่มใน'
    ],
    [
        'id' => 3,
        'name' => 'แกงแดง',
        'nameEn' => 'Red Curry',
        'price' => 90,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'curry',
        'available' => true,
        'description' => 'แกงแดงเข้มข้น ไก่นุ่ม ลูกชุมพร มะเขือ'
    ],
    [
        'id' => 4,
        'name' => 'ส้มตำ',
        'nameEn' => 'Som Tam',
        'price' => 50,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'salad',
        'available' => true,
        'description' => 'ส้มตำเมืองนอก รสชาติเผ็ด นำเมืองแท้'
    ],
    [
        'id' => 5,
        'name' => 'ลาบไก่',
        'nameEn' => 'Larb',
        'price' => 70,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'salad',
        'available' => true,
        'description' => 'ลาบไก่ สดใจสดสุก ด้วยสมุนไพร'
    ],
    [
        'id' => 6,
        'name' => 'น้ำเต้าหู้',
        'nameEn' => 'Tao Hoo',
        'price' => 40,
        'image' => 'assets/images/products/product-1(1).png',
        'category' => 'vegetarian',
        'available' => false,
        'description' => 'เต้าหู้นุ่ม ในน้ำแกงอ่อน'
    ]
];

// Get table number from QR code or session
$tableNumber = $_GET['table'] ?? $_SESSION['table_number'] ?? 1;
$_SESSION['table_number'] = $tableNumber;

// Get cart from session
$cart = $_SESSION['cart'] ?? [];
$cartCount = count($cart);

// Search functionality
$searchQuery = $_GET['search'] ?? '';
$categoryFilter = $_GET['category'] ?? '';

$filteredItems = $menuItems;

// Apply filters
if (!empty($searchQuery)) {
    $filteredItems = array_filter($filteredItems, function($item) use ($searchQuery) {
        $query = strtolower($searchQuery);
        return stripos($item['name'], $query) !== false || 
               stripos($item['nameEn'], $query) !== false ||
               stripos($item['description'], $query) !== false;
    });
}

if (!empty($categoryFilter)) {
    $filteredItems = array_filter($filteredItems, function($item) use ($categoryFilter) {
        return $item['category'] === $categoryFilter;
    });
}

// Get unique categories
$categories = array_unique(array_column($menuItems, 'category'));
$categoryLabels = [
    'noodles' => 'เส้นและผัด',
    'chicken' => 'ไก่',
    'curry' => 'แกง',
    'salad' => 'ยำและสลัด',
    'vegetarian' => 'เจ'
];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>เมนูอาหาร - โต๊ะ <?php echo $tableNumber; ?> | POS Restaurant</title>
    
    <?php include 'partials/head-css.php' ?>
    <link href="assets/css/customer-menu-list.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Header -->
    <div class="customer-header">
        <div class="table-info">
            📍 โต๊ะหมายเลข <strong><?php echo $tableNumber; ?></strong>
        </div>
        <h1>🍔 เมนูอาหาร</h1>
    </div>

    <!-- Search bar -->
    <div class="search-container">
        <form method="GET" class="d-flex gap-2">
            <input 
                type="hidden" 
                name="table" 
                value="<?php echo $tableNumber; ?>"
            >
            <input 
                type="text" 
                name="search" 
                class="search-input" 
                placeholder="🔍 ค้นหาเมนู..." 
                value="<?php echo htmlspecialchars($searchQuery); ?>"
            >
            <button type="submit" style="display: none;">ค้นหา</button>
        </form>
    </div>

    <!-- Category tabs -->
    <div class="category-tabs">
        <a href="?table=<?php echo $tableNumber; ?>" 
           class="category-btn <?php echo empty($categoryFilter) ? 'active' : ''; ?>">
            ทั้งหมด
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="?table=<?php echo $tableNumber; ?>&category=<?php echo $cat; ?>" 
               class="category-btn <?php echo $categoryFilter === $cat ? 'active' : ''; ?>">
                <?php echo $categoryLabels[$cat] ?? ucfirst($cat); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Menu grid -->
    <div class="menu-grid">
        <?php if (empty($filteredItems)): ?>
            <div class="empty-state" style="grid-column: 1/-1;">
                <div class="empty-state-icon">🍽️</div>
                <div class="empty-state-text">ไม่พบเมนูอาหาร</div>
            </div>
        <?php else: ?>
            <?php foreach ($filteredItems as $item): ?>
                <div 
                    class="menu-card <?php echo !$item['available'] ? 'unavailable' : ''; ?>"
                    onclick="<?php echo $item['available'] ? "window.location.href='customer-menu-detail.php?id={$item['id']}&table={$tableNumber}';" : ''; ?>"
                >
                    <?php if (!$item['available']): ?>
                        <div class="unavailable-badge">หมด</div>
                    <?php endif; ?>
                    
                    <img 
                        src="<?php echo $item['image']; ?>" 
                        alt="<?php echo htmlspecialchars($item['name']); ?>"
                        class="menu-card-image"
                        onerror="this.src='assets/images/placeholder.png'"
                    >
                    
                    <div class="menu-card-body">
                        <div class="menu-card-name">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </div>
                        
                        <div class="menu-card-price">
                            ฿<?php echo number_format($item['price'], 0); ?>
                        </div>
                        
                        <div class="menu-card-status <?php echo $item['available'] ? 'status-available' : 'status-unavailable'; ?>">
                            <?php echo $item['available'] ? '✓ พร้อมสั่ง' : '✗ หมดแล้ว'; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Cart bar -->
    <div class="cart-bar">
        <a href="customer-order-history.php?table=<?php echo $tableNumber; ?>" class="history-btn">
            📋 ประวัติ
        </a>
        <button class="cart-btn" onclick="window.location.href='customer-cart.php?table=<?php echo $tableNumber; ?>'">
            🛒 ตะกร้า
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge"><?php echo $cartCount; ?></span>
            <?php endif; ?>
        </button>
    </div>

    <!-- Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    
    <script>
        // Handle search input on change
        document.querySelector('.search-input')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });

        // Close keyboard on mobile after search
        document.querySelector('.search-input')?.addEventListener('blur', function() {
            if (window.innerHeight < document.documentElement.clientHeight) {
                window.scrollTo(0, 0);
            }
        });
    </script>
</body>
</html>
