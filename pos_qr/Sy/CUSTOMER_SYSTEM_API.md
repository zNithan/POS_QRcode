# 🔌 API Documentation - Customer Ordering System

## Overview

ระบบหน้าลูกค้า POS ใช้ Session-based architecture พร้อมพื้นฐาน AJAX สำหรับการเชื่อมต่อแบบ Real-time

## Session Variables Reference

### Global Session Variables

```php
// Table Information
$_SESSION['table_number']        // int: Current table number (1-20)

// Cart Data
$_SESSION['cart']                // array: Current shopping cart items

// Order Management
$_SESSION['current_order']       // array: Order being confirmed
$_SESSION['order_history']       // array: All orders for current table
```

---

## Endpoints

### 1. Menu List Endpoint

**File**: `customer-menu-list.php`

**Method**: GET / POST

**Parameters**:
```php
$_GET['table']      // (optional) int: Table number (default: $_SESSION['table_number'])
$_GET['search']     // (optional) string: Search query for menu items
$_GET['category']   // (optional) string: Category filter (noodles|chicken|curry|salad|vegetarian)
```

**Response**: HTML page with menu items

**Example URL**:
```
/customer-menu-list.php?table=1&search=ไก่&category=chicken
```

**Query Processing**:
```php
// Search filter
if (!empty($searchQuery)) {
    $filteredItems = array_filter($menuItems, function($item) use ($searchQuery) {
        return stripos($item['name'], $searchQuery) !== false || 
               stripos($item['nameEn'], $searchQuery) !== false ||
               stripos($item['description'], $searchQuery) !== false;
    });
}

// Category filter
if (!empty($categoryFilter)) {
    $filteredItems = array_filter($filteredItems, function($item) use ($categoryFilter) {
        return $item['category'] === $categoryFilter;
    });
}
```

**Menu Item Structure**:
```php
[
    'id'          => 1,                    // Menu ID
    'name'        => 'ผัดไทย',             // Thai name
    'nameEn'      => 'Pad Thai',           // English name
    'price'       => 60,                   // Price in Baht
    'image'       => 'assets/images/...',  // Image path
    'category'    => 'noodles',            // Category slug
    'available'   => true,                 // Availability status
    'description' => 'Description...'      // Menu description
]
```

---

### 2. Menu Detail Endpoint

**File**: `customer-menu-detail.php`

**Method**: GET / POST

**GET Parameters**:
```php
$_GET['id']         // int: Menu item ID (required)
$_GET['table']      // int: Table number (required)
```

**POST Parameters** (Add to Cart):
```php
$_POST['quantity']     // int: Quantity (1-20, required)
$_POST['notes']        // string: Special notes (optional)
$_POST['spicy_level']  // string: mild|normal|hot|veryHot (required)
$_POST['ajax']         // int: 1 = AJAX request, 0 = Form submit (optional)
```

**Response** (AJAX):
```json
{
  "success": true,
  "message": "เพิ่มลงตะกร้าแล้ว",
  "cartCount": 5
}
```

**Response** (Form Submit):
```
Redirect to: customer-cart.php?table=1&added=1
```

**Business Logic**:
```php
// Validate quantity
if ($quantity > 0 && $quantity <= 20) {
    // Create cart item
    $cartItem = [
        'id' => uniqid('item_'),
        'menu_id' => $menuId,
        'name' => $menuItem['name'],
        'price' => $menuItem['price'],
        'quantity' => $quantity,
        'notes' => $notes,
        'spicy_level' => $spicyLevel,
        'added_at' => date('Y-m-d H:i:s')
    ];
    
    $_SESSION['cart'][] = $cartItem;
}
```

---

### 3. Cart Endpoint

**File**: `customer-cart.php`

**Method**: GET / POST

**GET Parameters**:
```php
$_GET['table']      // int: Table number (required)
$_GET['added']      // int: 1 = show success message (optional)
```

**POST Actions**:

#### 3.1 Update Quantity
```php
$_POST['action']    // = 'update_quantity'
$_POST['item_id']   // string: Unique item ID
$_POST['quantity']  // int: New quantity (1-20, or 0 to remove)
$_POST['ajax']      // int: 1 (optional, for AJAX)
```

#### 3.2 Remove Item
```php
$_POST['action']    // = 'remove'
$_POST['item_id']   // string: Unique item ID
```

#### 3.3 Update Notes
```php
$_POST['action']    // = 'update_notes'
$_POST['item_id']   // string: Unique item ID
$_POST['notes']     // string: New notes
$_POST['ajax']      // int: 1 (optional, for AJAX)
```

#### 3.4 Confirm Order
```php
$_POST['action']    // = 'confirm_order'
```

**Response** (AJAX):
```json
{
  "success": true,
  "message": "อัปเดตแล้ว",
  "cartTotal": 200
}
```

**Response** (Confirm Order):
```
Redirect to: customer-order-confirmation.php?table=1
```

**Cart Item Operations**:
```php
// Update quantity
if ($action === 'update_quantity') {
    foreach ($cart as &$item) {
        if ($item['id'] === $itemId) {
            if ($quantity <= 0) {
                $cart = array_filter($cart, fn($i) => $i['id'] !== $itemId);
            } else {
                $item['quantity'] = min($quantity, 20);
            }
            break;
        }
    }
}

// Remove item
if ($action === 'remove') {
    $cart = array_filter($cart, fn($i) => $i['id'] !== $itemId);
}

// Update notes
if ($action === 'update_notes') {
    foreach ($cart as &$item) {
        if ($item['id'] === $itemId) {
            $item['notes'] = $notes;
            break;
        }
    }
}
```

---

### 4. Order Confirmation Endpoint

**File**: `customer-order-confirmation.php`

**Method**: GET / POST

**GET Parameters**:
```php
$_GET['table']      // int: Table number (required)
```

**POST Actions**:

#### 4.1 Confirm Order
```php
$_POST['action']    // = 'confirm'
```

Response:
```
Redirect to: customer-order-history.php?table=1&confirmed=1
```

#### 4.2 Cancel Order
```php
$_POST['action']    // = 'cancel'
```

Response:
```
Redirect to: customer-cart.php?table=1
```

**Order Creation Logic**:
```php
if ($action === 'confirm') {
    // Save order to history
    $_SESSION['order_history'][] = [
        'id' => 'ORD' . str_pad(count($_SESSION['order_history']) + 1, 3, '0', STR_PAD_LEFT),
        'table_number' => $tableNumber,
        'items' => $currentOrder['items'],
        'total_amount' => $currentOrder['total_amount'],
        'created_at' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];
    
    unset($_SESSION['current_order']);
}
```

---

### 5. Order History Endpoint

**File**: `customer-order-history.php`

**Method**: GET

**GET Parameters**:
```php
$_GET['table']      // int: Table number (required)
$_GET['confirmed']  // int: 1 = show success message (optional)
```

**Response**: HTML page with order history

**Auto-Refresh Mechanism**:
```javascript
// Fetch updated content every 10 seconds
setInterval(() => {
    fetch(window.location.href)
        .then(r => r.text())
        .then(html => {
            // Parse and update order section
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            const newContent = newDoc.querySelector('.history-content');
            
            if (newContent) {
                document.querySelector('.history-content').innerHTML = newContent.innerHTML;
            }
        });
}, 10000);
```

**Order History Structure**:
```php
[
    'id'              => 'ORD001',
    'table_number'    => 1,
    'items'           => [
        [
            'name'     => 'ผัดไทย',
            'quantity' => 2,
            'price'    => 60,
            'notes'    => 'ไม่ใส่ผัก'
        ]
    ],
    'total_amount'    => 120,
    'created_at'      => '2024-01-01 12:00:00',
    'status'          => 'pending|cooking|served'
]
```

---

### 6. QR Code Generator Endpoint

**File**: `pos-qr-code-generator.php`

**Method**: GET / POST

**GET Parameters**:
```php
$_GET['table']      // int: Table number for QR generation (optional)
$_GET['download']   // int: 1 = download QR as PNG (optional)
```

**Response** (Normal):
```html
HTML page with QR code dashboard
```

**Response** (Download):
```
PNG image file: Table-1-QRCode.png
```

**QR Code Generation**:
```php
function generateQRCodeURL($text) {
    $encoded = urlencode($text);
    return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$encoded}";
}

// Example:
$tableNumber = 1;
$url = "http://localhost/src/customer-menu-list.php?table=$tableNumber";
$qrImageURL = generateQRCodeURL($url);
```

**QR Code API Details**:
```
Service: qr-server.com
Endpoint: /v1/create-qr-code/
Parameters:
  - size: 300x300 (pixels)
  - data: URL-encoded text
  
Example:
https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=http%3A%2F%2Flocalhost%2Fcustomer-menu-list.php%3Ftable%3D1
```

---

## JavaScript API Methods

### Cart Management (AJAX)

**Update Quantity**:
```javascript
function updateQty(itemId, newQty) {
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
        location.reload();  // Or update DOM
    });
}
```

**Remove Item**:
```javascript
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
            location.reload();
        });
    }
}
```

**Update Notes**:
```javascript
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
        // Update UI
    });
}
```

---

## Error Handling

### Server-Side Validation

```php
// Quantity validation
if ($quantity <= 0 || $quantity > 20) {
    http_response_code(400);
    exit('Invalid quantity');
}

// Item ID validation
if (empty($itemId)) {
    http_response_code(400);
    exit('Missing item ID');
}

// Table number validation
if ($tableNumber < 1 || $tableNumber > 20) {
    http_response_code(400);
    exit('Invalid table number');
}
```

### Client-Side Validation

```javascript
// Before adding to cart
if (quantity < 1 || quantity > 20) {
    alert('จำนวนต้องอยู่ระหว่าง 1-20');
    return;
}

// Before removing item
if (confirm('ต้องการลบรายการนี้หรือไม่?')) {
    // Proceed
}
```

---

## Response Codes

### Success Responses

| Code | Scenario |
|------|----------|
| 200 | Successful request |
| 302 | Redirect (after form submit) |

### Error Responses

| Code | Scenario |
|------|----------|
| 400 | Invalid input (quantity, table, etc.) |
| 404 | Menu item not found |
| 500 | Server error |

---

## Rate Limiting & Throttling

### Recommended Limits (for future DB implementation)

```
Menu List Search: Max 1 request per 200ms
Add to Cart: Max 1 request per 300ms
Update Cart: Max 1 request per 500ms
Auto-refresh History: 1 request per 10s
```

---

## Data Validation Rules

### Menu Item

```
id: integer, > 0
name: string, 1-100 characters
price: integer, > 0
quantity: integer, 1-20
available: boolean
```

### Cart Item

```
id: string, unique (uniqid format)
menu_id: integer, > 0
name: string, non-empty
price: integer, > 0
quantity: integer, 1-20
notes: string, max 200 characters
spicy_level: string, one of [mild, normal, hot, veryHot]
```

### Order

```
table_number: integer, 1-20
items: array, non-empty
total_amount: integer, > 0
status: string, one of [pending, cooking, served]
created_at: string, valid datetime format
```

---

## Future Database Integration

### Sample SQL Queries

```sql
-- Get menu by ID
SELECT * FROM menus WHERE id = 1 AND available = 1;

-- Get all menus by category
SELECT * FROM menus WHERE category = 'chicken' AND available = 1;

-- Search menu
SELECT * FROM menus 
WHERE (name LIKE '%$query%' OR description LIKE '%$query%') 
AND available = 1;

-- Get order history for table
SELECT * FROM orders 
WHERE table_number = 1 
ORDER BY created_at DESC;

-- Insert new order
INSERT INTO orders (table_number, total_amount, status, created_at, items)
VALUES (1, 200, 'pending', NOW(), JSON_ARRAY(...));

-- Update order status
UPDATE orders SET status = 'cooking' WHERE id = 1;
```

---

## Webhooks & Events

### Potential Events for Future Implementation

```
menu.item.viewed       // When customer views menu
cart.item.added        // When item added to cart
cart.item.removed      // When item removed
order.created          // When order confirmed
order.status.changed   // When order status updates
```

---

## Rate Limiting Headers (Future)

```php
header('X-RateLimit-Limit: 60');
header('X-RateLimit-Remaining: 59');
header('X-RateLimit-Reset: ' . time() + 60);
```

---

## Security Headers

```php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000');
```

---

**Version**: 1.0.0  
**Last Updated**: December 2024  
**Status**: Stable ✓
