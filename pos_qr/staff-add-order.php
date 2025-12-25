<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Add Order";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .sticky-top {
                position: relative !important;
                top: 0 !important;
            }
            
            .card-body {
                padding: 0.75rem;
            }
            
            .nav-tabs-custom {
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .nav-tabs-custom::-webkit-scrollbar {
                display: none;
            }
            
            .nav-tabs-custom .nav-item {
                flex-shrink: 0;
            }
            
            #orderItems {
                max-height: 300px;
                overflow-y: auto;
            }
            
            .search-bar {
                max-width: 100% !important;
                margin-top: 0.5rem;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .row-cols-md-2 {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 0.5rem;
            }
            
            .menu-item .card-body {
                padding: 0.5rem;
            }
            
            .menu-item h6 {
                font-size: 0.875rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
            .container-xxl {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            h4 {
                font-size: 1.1rem;
            }
            
            h5 {
                font-size: 1rem;
            }
            
            h6 {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Add Order";
        
        $tableId = isset($_GET['table']) ? $_GET['table'] : 1;
        $tables = [
            ['id' => 1, 'name' => 'โต๊ะ 1'], ['id' => 2, 'name' => 'โต๊ะ 2'], ['id' => 3, 'name' => 'โต๊ะ 3'],
            ['id' => 4, 'name' => 'โต๊ะ 4'], ['id' => 5, 'name' => 'โต๊ะ 5'], ['id' => 6, 'name' => 'โต๊ะ 6'],
            ['id' => 7, 'name' => 'โต๊ะ 7'], ['id' => 8, 'name' => 'โต๊ะ 8'],
        ];

        $menuCategories = ['เมนูหลัก', 'เครื่องดื่ม', 'ของหวาน', 'เมนูพิเศษ'];

        $menuItems = [
            ['id' => 1, 'name' => 'ข้าวกะเพราไก่ไข่ดาว', 'price' => 120, 'category' => 'เมนูหลัก'],
            ['id' => 2, 'name' => 'ผัดไทยกุ้งสด', 'price' => 150, 'category' => 'เมนูหลัก'],
            ['id' => 3, 'name' => 'ต้มยำกุ้ง', 'price' => 180, 'category' => 'เมนูหลัก'],
            ['id' => 4, 'name' => 'สเต็กแซลมอน', 'price' => 320, 'category' => 'เมนูพิเศษ'],
            ['id' => 5, 'name' => 'ซีซาร์สลัด', 'price' => 110, 'category' => 'เมนูหลัก'],
            ['id' => 6, 'name' => 'ลาเต้เย็น', 'price' => 70, 'category' => 'เครื่องดื่ม'],
            ['id' => 7, 'name' => 'มอคค่าเย็น', 'price' => 75, 'category' => 'เครื่องดื่ม'],
            ['id' => 8, 'name' => 'ชาเขียวเย็น', 'price' => 60, 'category' => 'เครื่องดื่ม'],
            ['id' => 9, 'name' => 'บราวนี่ไอศกรีม', 'price' => 95, 'category' => 'ของหวาน'],
            ['id' => 10, 'name' => 'เค้กช็อคโกแลต', 'price' => 85, 'category' => 'ของหวาน'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3 g-md-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                                <a href="staff-dashboard.php" class="btn btn-soft-secondary btn-sm"><i class="bx bx-arrow-back"></i></a>
                                <div>
                                    <h4 class="mb-1">เพิ่มออเดอร์</h4>
                                    <p class="text-muted mb-0 d-none d-md-block">เลือกเมนูอาหารสำหรับโต๊ะ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-8 order-2 order-xl-1">
                        <div class="card">
                            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <h5 class="card-title mb-2 mb-md-0">เมนูอาหาร</h5>
                                <div class="search-bar w-100 w-md-auto">
                                    <span><i class="bx bx-search-alt"></i></span>
                                    <input type="search" class="form-control" placeholder="ค้นหาเมนู..." id="menuSearch">
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist" style="overflow-x: auto; flex-wrap: nowrap;">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-menu" role="tab">ทั้งหมด</a>
                                    </li>
                                    <?php foreach ($menuCategories as $cat): ?>
                                        <li class="nav-item" role="presentation" style="flex-shrink: 0;">
                                            <a class="nav-link" data-bs-toggle="tab" href="#<?php echo str_replace(' ', '-', $cat); ?>" role="tab"><?php echo $cat; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="all-menu">
                                        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 g-2 g-md-3" id="menuGrid">
                                            <?php foreach ($menuItems as $item): ?>
                                                <div class="col" data-category="<?php echo $item['category']; ?>" data-name="<?php echo strtolower($item['name']); ?>">
                                                    <div class="card border h-100 menu-item" data-id="<?php echo $item['id']; ?>" data-name="<?php echo $item['name']; ?>" data-price="<?php echo $item['price']; ?>">
                                                        <div class="card-body p-2">
                                                            <h6 class="mb-1 small"><?php echo $item['name']; ?></h6>
                                                            <p class="text-primary fw-bold mb-2 small">฿<?php echo number_format($item['price']); ?></p>
                                                            <button class="btn btn-sm btn-primary w-100 add-to-order">+เพิ่ม</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4 order-1 order-xl-2">
                        <div class="card sticky-top" style="top: 100px; z-index: 1;">
                            <div class="card-header">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                    <h5 class="card-title mb-0">ออเดอร์ปัจจุบัน</h5>
                                    <select class="form-select form-select-sm w-100 w-sm-auto" style="max-width: 150px;" id="tableSelect">
                                        <?php foreach ($tables as $t): ?>
                                            <option value="<?php echo $t['id']; ?>" <?php echo $t['id'] == $tableId ? 'selected' : ''; ?>><?php echo $t['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="orderItems" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                                    <p class="text-muted text-center">ยังไม่มีรายการ</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">หมายเหตุพิเศษ</label>
                                    <textarea class="form-control form-control-sm" rows="2" id="orderNotes" placeholder="เช่น ไม่เผ็ด, เพิ่มผัก..."></textarea>
                                </div>
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>รวมทั้งหมด</span>
                                        <h5 class="mb-0">฿<span id="totalAmount">0</span></h5>
                                    </div>
                                    <button class="btn btn-success w-100 mb-2" id="saveOrder">บันทึกออเดอร์</button>
                                    <button class="btn btn-outline-secondary w-100" id="clearOrder">ล้างรายการ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include "partials/footer.php" ?>
        </div>
    </div>

    <?php include 'partials/vendor-scripts.php' ?>
    <script>
        (function() {
            var orderItems = [];
            var orderContainer = document.getElementById('orderItems');
            var totalElement = document.getElementById('totalAmount');

            document.querySelectorAll('.add-to-order').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var card = this.closest('.menu-item');
                    var item = { id: card.dataset.id, name: card.dataset.name, price: parseFloat(card.dataset.price), qty: 1 };
                    var existing = orderItems.find(function(i) { return i.id === item.id; });
                    if (existing) { existing.qty++; } else { orderItems.push(item); }
                    renderOrder();
                });
            });

            function renderOrder() {
                if (orderItems.length === 0) {
                    orderContainer.innerHTML = '<p class="text-muted text-center">ยังไม่มีรายการ</p>';
                    totalElement.textContent = '0';
                    return;
                }
                var html = '';
                var total = 0;
                orderItems.forEach(function(item, idx) {
                    var subtotal = item.price * item.qty;
                    total += subtotal;
                    html += '<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">';
                    html += '<div class="flex-grow-1"><h6 class="mb-0">' + item.name + '</h6><small class="text-muted">฿' + item.price.toFixed(0) + ' x ' + item.qty + '</small></div>';
                    html += '<div class="d-flex align-items-center gap-1">';
                    html += '<button class="btn btn-sm btn-soft-secondary qty-dec" data-idx="' + idx + '">-</button>';
                    html += '<span class="fw-bold px-2">' + item.qty + '</span>';
                    html += '<button class="btn btn-sm btn-soft-secondary qty-inc" data-idx="' + idx + '">+</button>';
                    html += '<button class="btn btn-sm btn-soft-danger ms-2 remove-item" data-idx="' + idx + '"><i class="bx bx-x"></i></button>';
                    html += '</div></div>';
                });
                orderContainer.innerHTML = html;
                totalElement.textContent = total.toFixed(0);

                document.querySelectorAll('.qty-inc').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        orderItems[this.dataset.idx].qty++;
                        renderOrder();
                    });
                });
                document.querySelectorAll('.qty-dec').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        if (orderItems[this.dataset.idx].qty > 1) {
                            orderItems[this.dataset.idx].qty--;
                            renderOrder();
                        }
                    });
                });
                document.querySelectorAll('.remove-item').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        orderItems.splice(this.dataset.idx, 1);
                        renderOrder();
                    });
                });
            }

            document.getElementById('clearOrder').addEventListener('click', function() {
                if (confirm('ต้องการล้างรายการทั้งหมดใช่หรือไม่?')) {
                    orderItems = [];
                    renderOrder();
                }
            });

            document.getElementById('saveOrder').addEventListener('click', function() {
                if (orderItems.length === 0) {
                    alert('กรุณาเพิ่มรายการอาหารก่อนบันทึก');
                    return;
                }
                alert('บันทึกออเดอร์สำเร็จ\nโต๊ะ: ' + document.getElementById('tableSelect').options[document.getElementById('tableSelect').selectedIndex].text);
                window.location.href = 'staff-dashboard.php';
            });

            document.getElementById('menuSearch').addEventListener('input', function() {
                var query = this.value.toLowerCase();
                document.querySelectorAll('#menuGrid .col').forEach(function(col) {
                    col.style.display = col.dataset.name.includes(query) ? '' : 'none';
                });
            });
        })();
    </script>
</body>
</html>
