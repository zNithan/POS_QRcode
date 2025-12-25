# 📚 Usage Examples - Customer Ordering System

## 1️⃣ Menu List Page Examples

### Example 1: Basic Menu Display
```html
<!-- customer-menu-list.php -->
<div class="menu-grid">
    <div class="menu-card" onclick="window.location.href='customer-menu-detail.php?id=1&table=1'">
        <img src="assets/images/menu/pad-thai.jpg" alt="ผัดไทย" class="menu-card-image">
        <div class="menu-card-body">
            <div class="menu-card-name">ผัดไทย</div>
            <div class="menu-card-price">฿60</div>
            <div class="menu-card-status status-available">✓ พร้อมสั่ง</div>
        </div>
    </div>
</div>
```

### Example 2: Search Filter
```html
<!-- Search form in customer-menu-list.php -->
<div class="search-container">
    <form method="GET">
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
            onkeyup="this.form.submit();"
        >
    </form>
</div>

<!-- PHP processing -->
<?php
if (!empty($searchQuery)) {
    $filteredItems = array_filter($menuItems, function($item) use ($searchQuery) {
        $query = strtolower($searchQuery);
        return stripos($item['name'], $query) !== false;
    });
}
?>
```

### Example 3: Category Filter
```html
<!-- Category tabs -->
<div class="category-tabs">
    <a href="?table=1" class="category-btn active">ทั้งหมด</a>
    <a href="?table=1&category=noodles" class="category-btn">เส้นและผัด</a>
    <a href="?table=1&category=chicken" class="category-btn">ไก่</a>
    <a href="?table=1&category=curry" class="category-btn">แกง</a>
</div>

<!-- PHP logic -->
<?php
if (!empty($categoryFilter)) {
    $filteredItems = array_filter($filteredItems, function($item) use ($categoryFilter) {
        return $item['category'] === $categoryFilter;
    });
}
?>
```

---

## 2️⃣ Menu Detail Page Examples

### Example 1: Select Spicy Level
```html
<!-- Spicy level selector -->
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

<script>
function selectSpicy(btn) {
    // Remove active from all buttons
    document.querySelectorAll('.spicy-btn').forEach(b => {
        b.classList.remove('active');
    });
    // Add active to clicked button
    btn.classList.add('active');
    // Update hidden input
    document.getElementById('spicyLevel').value = btn.dataset.level;
}
</script>
```

### Example 2: Quantity Selector
```html
<!-- Quantity selector -->
<div class="quantity-selector">
    <span class="qty-label">จำนวนจาน</span>
    <div class="qty-controls">
        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
        <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="20" readonly>
        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
    </div>
</div>

<script>
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
</script>
```

### Example 3: Notes Textarea
```html
<!-- Special notes input -->
<div class="form-group">
    <label class="form-label">หมายเหตุพิเศษ</label>
    <p style="font-size: 0.85rem; color: #999;">
        เช่น ไม่ใส่ผัก, เพิ่มเนื้อ, ลดเกลือ ฯลฯ
    </p>
    <textarea 
        name="notes" 
        class="notes-input"
        placeholder="พิมพ์หมายเหตุพิเศษของคุณที่นี่..."
        maxlength="200"
    ></textarea>
</div>

<!-- Example notes users might add -->
<!-- ไม่ใส่ผัก -->
<!-- เผ็ดน้อย -->
<!-- เพิ่มเนื้อหมู -->
<!-- ลดเกลือ -->
<!-- เพิ่มลูกชุมพร -->
```

### Example 4: AJAX Add to Cart
```javascript
// Handle form submission with AJAX
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
            
            // Vibrate phone
            if (navigator.vibrate) {
                navigator.vibrate(100);
            }
            
            // Reset form
            document.getElementById('quantity').value = '1';
            document.querySelector('.spicy-btn.mild').click();
            
            // Hide message after 2 seconds
            setTimeout(() => {
                msg.classList.remove('show');
            }, 2000);
        }
    });
});
```

---

## 3️⃣ Cart Page Examples

### Example 1: Display Cart Items
```html
<!-- Cart item card -->
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
            ฿<?php echo formatCurrency($item['price']); ?> × <?php echo $item['quantity']; ?> 
            = <strong>฿<?php echo formatCurrency($item['price'] * $item['quantity']); ?></strong>
        </div>

        <div class="cart-item-qty">
            <span style="color: #666;">จำนวน:</span>
            <button class="qty-btn" onclick="updateQty('<?php echo $item['id']; ?>', <?php echo $item['quantity'] - 1; ?>)">−</button>
            <input type="number" class="qty-input" value="<?php echo $item['quantity']; ?>" readonly>
            <button class="qty-btn" onclick="updateQty('<?php echo $item['id']; ?>', <?php echo $item['quantity'] + 1; ?>)">+</button>
        </div>

        <!-- Spicy level -->
        <div class="cart-item-spicy">
            🌶️ <?php echo $spicyLabels[$item['spicy_level']] ?? 'ปกติ'; ?>
        </div>

        <!-- Notes -->
        <div class="cart-item-notes" id="notes-display-<?php echo $item['id']; ?>" 
             onclick="toggleEditNotes('<?php echo $item['id']; ?>')">
            <?php if (!empty($item['notes'])): ?>
                📝 <?php echo htmlspecialchars($item['notes']); ?> (แตะเพื่อแก้ไข)
            <?php else: ?>
                <span style="color: #bbb;">แตะเพื่อเพิ่มหมายเหตุ</span>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
```

### Example 2: Update Quantity via AJAX
```javascript
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
```

### Example 3: Edit Notes Inline
```javascript
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
            display.innerHTML = '📝 ' + notes.replace(/</g, '&lt;') + ' (แตะเพื่อแก้ไข)';
        } else {
            display.innerHTML = '<span style="color: #bbb;">แตะเพื่อเพิ่มหมายเหตุ</span>';
        }
    });
}
```

### Example 4: Calculate and Display Total
```php
<?php
function calculateTotal($items) {
    return array_sum(array_map(
        fn($i) => $i['price'] * $i['quantity'], 
        $items
    ));
}

function formatCurrency($amount) {
    return number_format($amount, 0);
}

$total = calculateTotal($cart);
?>

<!-- Display in template -->
<div class="summary-row">
    <span>รวม (<?php echo count($cart); ?> รายการ)</span>
    <span class="total-amount">฿<?php echo formatCurrency($total); ?></span>
</div>
```

---

## 4️⃣ Order Confirmation Examples

### Example 1: Order Review
```html
<!-- Order summary review -->
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

<!-- Total display -->
<div class="total-section">
    <div class="total-label">รวมทั้งสิ้น</div>
    <div class="total-amount">฿<?php echo number_format($total, 0); ?></div>
</div>
```

### Example 2: Confirmation Form
```html
<!-- Form with both confirm and cancel options -->
<form method="POST" class="button-group" id="confirmationForm">
    <input type="hidden" name="action" value="confirm" id="actionInput">
    
    <button type="button" class="btn btn-cancel" onclick="cancelOrder()">
        ← ยกเลิก
    </button>
    <button type="submit" class="btn btn-confirm">
        ✓ ยืนยันการสั่ง
    </button>
</form>

<script>
function cancelOrder() {
    if (confirm('ต้องการยกเลิกการสั่งอาหารหรือไม่?')) {
        document.getElementById('actionInput').value = 'cancel';
        document.getElementById('confirmationForm').submit();
    }
}
</script>
```

---

## 5️⃣ Order History Examples

### Example 1: Display Order Cards
```html
<!-- Order history card -->
<div class="order-card" id="order-ORD001">
    <div class="order-header">
        <div>
            <div class="order-id">ออเดอร์ #001</div>
            <div class="order-time">
                📅 12:00 - 01/12/2024
            </div>
        </div>
        <div class="order-status status-served">
            ✓ เสิร์ฟแล้ว
        </div>
    </div>

    <!-- Order items -->
    <div class="order-items">
        <div class="order-item">
            <div class="item-info">
                <div class="item-name">ผัดไทย × 2</div>
                <div class="item-notes">📝 ไม่ใส่ผัก</div>
            </div>
            <div class="item-qty-price">฿120</div>
        </div>
    </div>

    <!-- Total -->
    <div class="order-total">
        <span class="total-label">รวมทั้งสิ้น</span>
        <span class="total-amount">฿120</span>
    </div>

    <!-- Timeline -->
    <div class="order-timeline">
        <div class="timeline-step active">✓ ยืนยัน</div>
        <div class="timeline-step active">👨‍🍳 ทำ</div>
        <div class="timeline-step active">🍽️ เสิร์ฟ</div>
    </div>
</div>
```

### Example 2: Auto-Refresh Implementation
```javascript
// Auto-refresh orders every 10 seconds
const autoRefresh = setInterval(() => {
    fetch(window.location.href)
        .then(r => r.text())
        .then(html => {
            // Parse new HTML
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            const newContent = newDoc.querySelector('.history-content');
            
            // Update current content
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
```

### Example 3: Manual Refresh
```javascript
function refreshOrders() {
    location.reload();
}

// Keyboard shortcut: R to refresh
document.addEventListener('keyup', (e) => {
    if (e.key === 'r' || e.key === 'R') {
        refreshOrders();
    }
});
```

---

## 6️⃣ QR Code Generator Examples

### Example 1: Single Table QR Generation
```javascript
function selectTable(tableNum) {
    selectedTable = tableNum;
    
    // Update active button
    document.querySelectorAll('.table-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-table="${tableNum}"]`).classList.add('active');

    // Generate QR code URL
    const baseURL = '<?php echo $baseURL; ?>';
    const customerURL = `${baseURL}/customer-menu-list.php?table=${tableNum}`;
    const qrImageURL = generateQRURL(customerURL);

    // Update display
    document.getElementById('qrImage').src = qrImageURL;
    document.getElementById('qrTitle').textContent = `QR Code สำหรับโต๊ะ ${tableNum}`;
    document.getElementById('directLink').textContent = customerURL;
    document.getElementById('qrDisplay').classList.add('show');
}

function generateQRURL(text) {
    const encoded = encodeURIComponent(text);
    return `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encoded}`;
}
```

### Example 2: Batch Print Multiple Tables
```javascript
function batchPrint() {
    const start = parseInt(document.getElementById('startTable').value);
    const end = parseInt(document.getElementById('endTable').value);

    if (start < 1 || end > 20 || start > end) {
        alert('กรุณากรอกช่วงโต๊ะที่ถูกต้อง (1-20)');
        return;
    }

    // Create new print window
    const printWindow = window.open('', '_blank');
    const baseURL = '<?php echo $baseURL; ?>';
    
    let html = '<html><head><style>';
    html += '.qr-item { page-break-inside: avoid; text-align: center; margin-bottom: 30px; }';
    html += '.qr-item h2 { margin: 0; }';
    html += '.qr-item img { max-width: 300px; }';
    html += '</style></head><body>';

    // Generate QR for each table
    for (let i = start; i <= end; i++) {
        const url = `${baseURL}/customer-menu-list.php?table=${i}`;
        const qrURL = generateQRURL(url);
        html += `<div class="qr-item"><h2>โต๊ะ ${i}</h2><img src="${qrURL}" alt="QR ${i}"></div>`;
    }

    html += '</body></html>';
    
    printWindow.document.write(html);
    printWindow.document.close();
    
    setTimeout(() => {
        printWindow.print();
    }, 1000);
}
```

---

## 7️⃣ Session Management Examples

### Example 1: Initialize Session
```php
<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Set table number
if (!empty($_GET['table'])) {
    $_SESSION['table_number'] = intval($_GET['table']);
}

// Get current values
$cart = $_SESSION['cart'];
$tableNumber = $_SESSION['table_number'] ?? 1;
?>
```

### Example 2: Add Item to Cart
```php
<?php
$cartItem = [
    'id' => uniqid('item_'),
    'menu_id' => $menuId,
    'name' => $menuItem['name'],
    'price' => $menuItem['price'],
    'quantity' => intval($_POST['quantity'] ?? 1),
    'notes' => $_POST['notes'] ?? '',
    'spicy_level' => $_POST['spicy_level'] ?? 'normal',
    'added_at' => date('Y-m-d H:i:s')
];

$_SESSION['cart'][] = $cartItem;
?>
```

### Example 3: Save Order to History
```php
<?php
if ($_POST['action'] === 'confirm_order') {
    // Initialize history if not exists
    if (!isset($_SESSION['order_history'])) {
        $_SESSION['order_history'] = [];
    }
    
    // Create order from current cart
    $order = [
        'id' => 'ORD' . str_pad(count($_SESSION['order_history']) + 1, 3, '0', STR_PAD_LEFT),
        'table_number' => $tableNumber,
        'items' => $_SESSION['cart'],
        'total_amount' => calculateTotal($_SESSION['cart']),
        'created_at' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];
    
    // Save to history
    $_SESSION['order_history'][] = $order;
    
    // Clear current order
    $_SESSION['cart'] = [];
    unset($_SESSION['current_order']);
}
?>
```

---

## 8️⃣ Mobile-Specific Features

### Example 1: Haptic Feedback (Vibration)
```javascript
// Add vibration when item added to cart
if (navigator.vibrate) {
    navigator.vibrate(100);  // 100ms vibration
}

// Multiple pulses for confirmation
if (navigator.vibrate) {
    navigator.vibrate([100, 50, 100]);  // pulse, pause, pulse
}
```

### Example 2: Mobile Keyboard Handling
```javascript
// Close keyboard and scroll to top after search
document.querySelector('.search-input')?.addEventListener('blur', function() {
    if (window.innerHeight < document.documentElement.clientHeight) {
        window.scrollTo(0, 0);
    }
});
```

### Example 3: Viewport Configuration
```html
<!-- In <head> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<!-- viewport-fit=cover for iPhone X notch support -->
```

---

## 🎓 Best Practices Demonstrated

1. **Session Management**: All data persists using PHP sessions
2. **Responsive Design**: Mobile-first CSS Grid layout
3. **User Experience**: Smooth transitions and feedback
4. **Error Handling**: Graceful fallbacks and user messages
5. **Accessibility**: Clear labels and semantic HTML
6. **Performance**: Minimal dependencies and efficient JS
7. **Security**: Input validation and output escaping
8. **Maintainability**: Clean code and clear structure

---

**Happy Coding! 🚀**
