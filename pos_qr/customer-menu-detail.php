<?php 
session_start();

// Mock menu database
$allMenuItems = [
    [
        'id' => 1,
        'name' => 'ผัดไทย',
        'nameEn' => 'Pad Thai',
        'price' => 60,
        'image' => '',
        'category' => 'noodles',
        'available' => true,
        'description' => 'เส้นเล็ก ผัดกลม ด้วยไข่ กุ้งแห้ง ถั่วงอก หอม'
    ],
    [
        'id' => 2,
        'name' => 'ไก่ทอด',
        'nameEn' => 'Fried Chicken',
        'price' => 80,
        'image' => '',
        'category' => 'chicken',
        'available' => true,
        'description' => 'ไก่ต้นกำลัง ทอดกรอบนอกนุ่มใน'
    ],
    [
        'id' => 3,
        'name' => 'แกงแดง',
        'nameEn' => 'Red Curry',
        'price' => 90,
        'image' => '',
        'category' => 'curry',
        'available' => true,
        'description' => 'แกงแดงเข้มข้น ไก่นุ่ม ลูกชุมพร มะเขือ'
    ],
    [
        'id' => 4,
        'name' => 'ส้มตำ',
        'nameEn' => 'Som Tam',
        'price' => 50,
        'image' => '',
        'category' => 'salad',
        'available' => true,
        'description' => 'ส้มตำเมืองนอก รสชาติเผ็ด นำเมืองแท้'
    ],
    [
        'id' => 5,
        'name' => 'ลาบไก่',
        'nameEn' => 'Larb',
        'price' => 70,
        'image' => '',
        'category' => 'salad',
        'available' => true,
        'description' => 'ลาบไก่ สดใจสดสุก ด้วยสมุนไพร'
    ],
    [
        'id' => 6,
        'name' => 'น้ำเต้าหู้',
        'nameEn' => 'Tao Hoo',
        'price' => 40,
        'image' => '',
        'category' => 'vegetarian',
        'available' => true,
        'description' => 'เต้าหู้นุ่ม ในน้ำแกงอ่อน'
    ]
];

// Get parameters
$menuId = intval($_GET['id'] ?? 0);
$tableNumber = intval($_GET['table'] ?? $_SESSION['table_number'] ?? 1);
$_SESSION['table_number'] = $tableNumber;

// Find menu item
$menuItem = null;
foreach ($allMenuItems as $item) {
    if ($item['id'] === $menuId) {
        $menuItem = $item;
        break;
    }
}

// If not found, redirect
if (!$menuItem) {
    header('Location: customer-menu-list.php?table=' . $tableNumber);
    exit();
}

// Initialize cart if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity'] ?? 1);
    $notes = $_POST['notes'] ?? '';
    $spicyLevel = $_POST['spicy_level'] ?? 'normal';
    
    if ($quantity > 0 && $quantity <= 20) {
        // Create cart item
        $cartItemId = uniqid('item_');
        $cartItem = [
            'id' => $cartItemId,
            'menu_id' => $menuId,
            'name' => $menuItem['name'],
            'price' => $menuItem['price'],
            'quantity' => $quantity,
            'notes' => $notes,
            'spicy_level' => $spicyLevel,
            'added_at' => date('Y-m-d H:i:s')
        ];
        
        $_SESSION['cart'][] = $cartItem;
        
        // Return success response for AJAX
        if (!empty($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'เพิ่มลงตะกร้าแล้ว', 'cartCount' => count($_SESSION['cart'])]);
            exit();
        }
        
        // Redirect to cart
        header('Location: customer-cart.php?table=' . $tableNumber . '&added=1');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo htmlspecialchars($menuItem['name']); ?> | POS Restaurant</title>
    
    <?php include 'partials/head-css.php' ?>
    <link href="assets/css/customer-menu-detail.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Header -->
    <div class="detail-header">
        <button class="back-btn" onclick="window.history.back()">
            ←
        </button>
        <h2 style="margin: 0; flex: 1; font-size: 1.1rem;">รายละเอียดเมนู</h2>
    </div>

    <!-- Content -->
    <div class="detail-container">
        <!-- Image -->
        <div class="image-section">
            <img 
                src="<?php echo htmlspecialchars($menuItem['image']); ?>" 
                alt="<?php echo htmlspecialchars($menuItem['name']); ?>"
                class="menu-image"
                onerror="this.src='assets/images/placeholder.png'"
            >
        </div>

        <!-- Content -->
        <div class="content-section">
            <div class="menu-header">
                <h1 class="menu-name"><?php echo htmlspecialchars($menuItem['name']); ?></h1>
                <p class="menu-name-en"><?php echo htmlspecialchars($menuItem['nameEn']); ?></p>
                <p class="menu-description">
                    <?php echo htmlspecialchars($menuItem['description']); ?>
                </p>
            </div>
            
            <div class="price-badge">
                ฿<?php echo number_format($menuItem['price'], 0); ?>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" class="form-section" id="addToCartForm">
            <!-- Spicy Level -->
            <div class="form-group">
                <label class="form-label">ระดับความเผ็ด</label>
                <div class="spicy-options">
                    <button type="button" class="spicy-btn mild active" data-level="mild" onclick="selectSpicy(this)">
                        😊 น้อย
                    </button>
                    <button type="button" class="spicy-btn normal" data-level="normal" onclick="selectSpicy(this)">
                        🤔 ปกติ
                    </button>
                    <button type="button" class="spicy-btn hot" data-level="hot" onclick="selectSpicy(this)">
                        🔥 เผ็ด
                    </button>
                    <button type="button" class="spicy-btn veryHot" data-level="veryHot" onclick="selectSpicy(this)">
                        🌶️ เผ็ดมาก
                    </button>
                </div>
                <input type="hidden" name="spicy_level" id="spicyLevel" value="mild">
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">หมายเหตุพิเศษ</label>
                <p style="font-size: 0.85rem; color: #999; margin: 0 0 0.5rem 0;">
                    เช่น ไม่ใส่ผัก, เพิ่มเนื้อ, ลดเกลือ ฯลฯ
                </p>
                <textarea 
                    name="notes" 
                    class="notes-input"
                    placeholder="พิมพ์หมายเหตุพิเศษของคุณที่นี่..."
                ></textarea>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label class="form-label">จำนวน</label>
                <div class="quantity-selector">
                    <span class="qty-label">จำนวนจาน</span>
                    <div class="qty-controls">
                        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="20" readonly>
                        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>
            </div>

            <!-- Button area -->
            <div style="height: 80px;"></div>
        </form>
    </div>

    <!-- Button section -->
    <div class="button-section">
        <a href="customer-menu-list.php?table=<?php echo $tableNumber; ?>" class="btn-continue">
            เลือกเพิ่ม
        </a>
        <button type="submit" form="addToCartForm" class="btn-add" id="addBtn">
            🛒 เพิ่มลงตะกร้า
        </button>
    </div>

    <!-- Success message -->
    <div class="success-message" id="successMsg">
        ✓ เพิ่มลงตะกร้าแล้ว
    </div>

    <script>
        function selectSpicy(btn) {
            document.querySelectorAll('.spicy-btn').forEach(b => {
                b.classList.remove('active');
            });
            btn.classList.add('active');
            document.getElementById('spicyLevel').value = btn.dataset.level;
        }

        function increaseQty() {
            let qty = document.getElementById('quantity');
            let val = parseInt(qty.value) || 1;
            if (val < 20) {
                qty.value = val + 1;
            }
        }

        function decreaseQty() {
            let qty = document.getElementById('quantity');
            let val = parseInt(qty.value) || 1;
            if (val > 1) {
                qty.value = val - 1;
            }
        }

        // Handle form submission
        document.getElementById('addToCartForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('ajax', '1');
            
            fetch('<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $menuId; ?>&table=<?php echo $tableNumber; ?>', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const msg = document.getElementById('successMsg');
                    msg.classList.add('show');
                    
                    // Vibrate if available
                    if (navigator.vibrate) {
                        navigator.vibrate(100);
                    }
                    
                    // Reset form
                    document.getElementById('quantity').value = '1';
                    document.querySelector('.spicy-btn.mild').click();
                    document.querySelector('.notes-input').value = '';
                    
                    // Hide message after 2 seconds
                    setTimeout(() => {
                        msg.classList.remove('show');
                    }, 2000);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                // Fallback to traditional submit
                this.submit();
            });
        });
    </script>
</body>
</html>
