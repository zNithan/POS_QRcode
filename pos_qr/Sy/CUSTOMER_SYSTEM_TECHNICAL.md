# 🔧 Technical Documentation - Customer Ordering System

## Architecture Overview

```
┌─────────────────────────────────────────────┐
│         QR Code Scanner (Mobile)            │
│  (กล้องโทรศัพท์สแกน QR Code)                │
└────────────────┬────────────────────────────┘
                 │
                 ↓
        ┌────────────────────┐
        │ QR Link Generated  │
        │ (with table param) │
        └────────────────────┘
                 │
                 ↓
    ┌────────────────────────────┐
    │  customer-menu-list.php    │  ← หน้าแรก
    │  (เลือกเมนูอาหาร)          │
    └────┬───────────┬──────────┘
         │           │
         ↓           ↓
    ┌──────────────┐  ┌──────────────┐
    │  Detail      │  │  History     │
    │  Page        │  │  Page        │
    └─────┬────────┘  └──────────────┘
          │
          ↓
    ┌──────────────┐
    │  Cart        │
    │  (SESSION)   │
    └─────┬────────┘
          │
          ↓
    ┌──────────────┐
    │ Confirmation │
    │  (validate)  │
    └─────┬────────┘
          │
          ↓
    ┌──────────────┐
    │  Saved to    │
    │  SESSION or  │
    │  DATABASE    │
    └──────────────┘
```

## File Structure

### 1. customer-menu-list.php
**Purpose**: Display all menu items with search and filter

**Key Variables**:
```php
$menuItems        // Array of all menu items
$tableNumber      // Current table number from QR code
$cartCount        // Count of items in cart
$searchQuery      // Search keyword
$categoryFilter   // Selected category
$filteredItems    // Filtered menu items
```

**Key Functions**:
- Filter by search query (name/English/description)
- Filter by category
- Display as responsive grid (2-4 columns)
- Show availability status

**Session Usage**:
```php
$_SESSION['table_number']  // Store current table
$_SESSION['cart']          // Referenced for count
```

**Flow**:
```
Load → Filter (search + category) → Display Grid → 
Click Item → Go to Detail Page
```

---

### 2. customer-menu-detail.php
**Purpose**: Show menu details and add to cart

**Key Variables**:
```php
$menuItem     // Selected menu item
$tableNumber  // Current table
$menuId       // Menu ID from GET
```

**Key Functions**:
- Display menu details with image
- Select spicy level (4 buttons)
- Add special notes (textarea)
- Quantity selector (+ / -)
- Add to cart via AJAX or POST

**Form Submission**:
```php
POST data:
- quantity: int (1-20)
- notes: string
- spicy_level: mild|normal|hot|veryHot
- ajax: 1 (optional, for AJAX request)
```

**Response**:
```json
{
  "success": true,
  "message": "เพิ่มลงตะกร้าแล้ว",
  "cartCount": 5
}
```

**Session Update**:
```php
$_SESSION['cart'][] = [
    'id' => 'item_xxxxx',
    'menu_id' => 1,
    'name' => 'ผัดไทย',
    'price' => 60,
    'quantity' => 2,
    'notes' => 'ไม่ใส่ผัก',
    'spicy_level' => 'hot',
    'added_at' => date()
]
```

---

### 3. customer-cart.php
**Purpose**: Manage shopping cart

**Key Variables**:
```php
$cart         // Array of cart items from SESSION
$tableNumber  // Current table
$total        // Calculate total price
```

**POST Actions**:
```php
'action' => 'update_quantity'  // Update quantity
'action' => 'remove'           // Remove item
'action' => 'update_notes'     // Edit notes
'action' => 'confirm_order'    // Confirm order
```

**JavaScript Functions**:
```javascript
updateQty(itemId, newQty)      // Update quantity
removeItem(itemId)              // Delete item
toggleEditNotes(itemId)         // Toggle edit form
saveNotes(e, itemId)            // Save notes via AJAX
```

**Price Calculation**:
```php
function calculateTotal($items) {
    return array_sum(array_map(
        fn($i) => $i['price'] * $i['quantity'], 
        $items
    ));
}
```

**Flow**:
```
Display Cart Items → 
Edit Quantity/Notes/Remove → 
Show Total → 
Click Confirm → 
Go to Confirmation
```

---

### 4. customer-order-confirmation.php
**Purpose**: Review order before submitting

**Key Variables**:
```php
$currentOrder  // Order from SESSION['current_order']
$tableNumber   // Current table
$total         // Total amount
```

**POST Actions**:
```php
'action' => 'confirm'  // Confirm order
'action' => 'cancel'   // Cancel and go back to cart
```

**Order Structure Saved**:
```php
$_SESSION['current_order'] = [
    'table_number' => 1,
    'items' => [...],
    'total_amount' => 200,
    'created_at' => date('Y-m-d H:i:s'),
    'status' => 'pending'
];
```

**After Confirmation**:
```php
// Save to history
$_SESSION['order_history'][] = $currentOrder;
// Clear current
unset($_SESSION['current_order']);
// Redirect to history
header('Location: customer-order-history.php');
```

---

### 5. customer-order-history.php
**Purpose**: Display order history with real-time status updates

**Key Variables**:
```php
$allOrders     // Array of all orders
$tableOrders   // Filtered orders for current table
```

**Order Status**:
```php
'pending'   // รอทำ (Waiting)
'cooking'   // กำลังทำ (Cooking)
'served'    // เสิร์ฟแล้ว (Served)
```

**Auto-Refresh Implementation**:
```javascript
setInterval(() => {
    fetch(window.location.href)
        .then(r => r.text())
        .then(html => {
            // Update order section
        });
}, 10000);  // Every 10 seconds
```

**Timeline Visualization**:
```
✓ ยืนยัน → 👨‍🍳 ทำ → 🍽️ เสิร์ฟ
```

---

### 6. pos-qr-code-generator.php
**Purpose**: Generate and manage QR codes for tables

**Key Functions**:
```php
generateQRCodeURL($text)  // Generate QR code using API
```

**URL Structure**:
```
Base: http://localhost/src/
Link: http://localhost/src/customer-menu-list.php?table=1
QR Code: https://api.qrserver.com/v1/create-qr-code/?data={url}
```

**Features**:
- Single table QR code generation
- Batch print multiple tables (1-20)
- Download QR code as PNG
- Copy direct link to clipboard

**QR API Used**:
```
Service: qr-server.com
Endpoint: /v1/create-qr-code/
Parameters: size=400x400&data={encoded_url}
No authentication required
```

---

## Data Flow Diagrams

### New Customer Flow
```
1. Scan QR Code
   └─→ URL: /customer-menu-list.php?table=1
   
2. Menu List Page
   ├─ Search: Filter by name
   ├─ Category: Filter by type
   └─ Click: Go to detail
   
3. Menu Detail Page
   ├─ Select spicy level
   ├─ Add notes
   ├─ Set quantity
   └─ Add to cart
   
4. Cart Page
   ├─ View cart items
   ├─ Edit quantity
   ├─ Edit notes
   ├─ Remove items
   └─ Confirm order
   
5. Confirmation Page
   ├─ Review order
   ├─ See total price
   └─ Confirm/Cancel
   
6. Order History
   └─ Auto-refresh status
```

### Session Data Flow
```
Session Start
    ├─ $_SESSION['table_number'] = 1
    ├─ $_SESSION['cart'] = []
    └─ $_SESSION['order_history'] = []

Add Item to Cart
    └─ $_SESSION['cart'][] = $item

Confirm Order
    ├─ $_SESSION['current_order'] = $cart + meta
    ├─ $_SESSION['order_history'][] = $order
    └─ $_SESSION['cart'] = []

View History
    └─ Read $_SESSION['order_history']
```

---

## CSS Grid Responsive Breakpoints

### Menu List Grid
```css
/* Mobile (< 480px) */
grid-template-columns: repeat(auto-fill, minmax(150px, 1fr))

/* Tablet (480px - 768px) */
grid-template-columns: repeat(auto-fill, minmax(180px, 1fr))

/* Desktop (> 768px) */
grid-template-columns: repeat(auto-fill, minmax(200px, 1fr))
```

---

## Form Submissions

### Add to Cart (POST)
```html
<form method="POST" id="addToCartForm">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="spicy_level" value="mild">
    <textarea name="notes" placeholder="..."></textarea>
    <button type="submit">Add to Cart</button>
</form>
```

### Update Cart (AJAX POST)
```javascript
const form = new FormData();
form.append('action', 'update_quantity');
form.append('item_id', itemId);
form.append('quantity', newQty);
form.append('ajax', '1');

fetch(window.location.href, {
    method: 'POST',
    body: form
})
```

### Confirm Order (POST)
```html
<form method="POST">
    <input type="hidden" name="action" value="confirm_order">
    <button type="submit">Confirm</button>
</form>
```

---

## JavaScript Event Handlers

### Menu Detail Page
```javascript
selectSpicy(btn)          // Select spicy level
increaseQty()             // Quantity +
decreaseQty()             // Quantity -
addToCartForm.submit()    // Submit with AJAX
```

### Cart Page
```javascript
updateQty(itemId, qty)    // AJAX update quantity
removeItem(itemId)        // AJAX delete item
toggleEditNotes(itemId)   // Show/hide edit form
saveNotes(e, itemId)      // AJAX save notes
confirmForm.submit()      // Confirm order
```

### History Page
```javascript
autoRefresh()             // Auto-refresh every 10s
refreshOrders()           // Manual refresh
// Keyboard shortcut: R to refresh
```

---

## Integration with Existing Template

### Used CSS Classes
```
container-fluid / container-xxl
card / card-body / card-header
btn / btn-primary / btn-sm
alert / alert-primary
d-flex / flex-grow-1 / gap-X
row / col / col-lg / col-md
avatar-md / rounded / bg-light
text-dark / text-muted / text-primary
```

### Used Icons (from Solar/Boxicons)
```
solar:cart-5-bold-duotone
solar:trash-bin-minimalistic-bold-duotone
solar:heart-bold-duotone
solar:eye-broken
solar:pen-2-broken
bx:search
bx:arrow-back
```

---

## Performance Considerations

### Optimization Done
```
✓ CSS Grid instead of Bootstrap (faster)
✓ Minimal JavaScript (vanilla, no jQuery)
✓ Local Session Storage (no DB queries for demo)
✓ Fetch API instead of jQuery AJAX
✓ Lazy image loading placeholders
✓ Viewport meta for mobile rendering
```

### Further Optimization
```
→ Implement service workers for offline support
→ Minify CSS/JS in production
→ Use image CDN and WebP format
→ Implement database caching
→ Use Redis for session storage
```

---

## Error Handling

### User-Friendly Messages
```
✓ "ไม่พบเมนูอาหาร" - Empty search result
✓ "ตะกร้าว่างเปล่า" - Empty cart
✓ "ไม่มีประวัติการสั่งอาหาร" - No orders
✓ "เพิ่มลงตะกร้าแล้ว" - Success notification
```

### Error Logging
```php
// Add to production deployment:
error_log("Cart action failed: " . json_encode($error));
```

---

## Migration to Production

### Database Setup
```sql
CREATE TABLE menus (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    price INT,
    image_url VARCHAR(255),
    category VARCHAR(100),
    available BOOLEAN
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_number INT,
    total_amount INT,
    status VARCHAR(50),
    created_at TIMESTAMP,
    items JSON
);
```

### Replace Mock Data
```php
// In customer-menu-list.php
$result = mysqli_query($conn, 
    "SELECT * FROM menus WHERE available = 1");
$menuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

// In customer-order-history.php
$result = mysqli_query($conn,
    "SELECT * FROM orders WHERE table_number = ? ORDER BY created_at DESC");
```

---

## Security Hardening Checklist

- [ ] Use prepared statements for all DB queries
- [ ] Validate and sanitize all inputs
- [ ] Implement CSRF tokens
- [ ] Use HTTPS in production
- [ ] Add authentication for admin QR generator
- [ ] Rate limit API endpoints
- [ ] Log all order transactions
- [ ] Add table access validation
- [ ] Implement order confirmation tokens

---

**Last Updated**: December 2024
**Version**: 1.0.0
**Status**: Production Ready
