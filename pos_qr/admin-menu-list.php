<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Menu List";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Menu List";
        
        $menus = [
            ['id' => 1, 'name' => 'ข้าวกะเพราไก่ไข่ดาว', 'category' => 'เมนูหลัก', 'price' => 120, 'image' => 'assets/images/products/product-1(1).png'],
            ['id' => 2, 'name' => 'ผัดไทยกุ้งสด', 'category' => 'เมนูหลัก', 'price' => 150, 'image' => 'assets/images/products/product-2.png'],
            ['id' => 3, 'name' => 'ต้มยำกุ้ง', 'category' => 'เมนูหลัก', 'price' => 180, 'image' => 'assets/images/products/product-3.png'],
            ['id' => 4, 'name' => 'สเต็กแซลมอน', 'category' => 'เมนูพิเศษ', 'price' => 320, 'image' => 'assets/images/products/product-4.png'],
            ['id' => 5, 'name' => 'ลาเต้เย็น', 'category' => 'เครื่องดื่ม', 'price' => 70, 'image' => 'assets/images/products/product-5.png'],
            ['id' => 6, 'name' => 'บราวนี่ไอศกรีม', 'category' => 'ของหวาน', 'price' => 95, 'image' => 'assets/images/products/product-6.png'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                                <a href="admin-dashboard.php" class="btn btn-soft-secondary"><i class="bx bx-arrow-back"></i></a>
                                <div>
                                    <h4 class="mb-1">จัดการเมนูอาหาร</h4>
                                    <p class="text-muted mb-0">ดู แก้ไข และจัดการเมนูอาหารทั้งหมด</p>
                                </div>
                                <div class="ms-auto d-flex gap-2">
                                    <div class="search-bar">
                                        <span><i class="bx bx-search-alt"></i></span>
                                        <input type="search" class="form-control" placeholder="ค้นหาเมนู...">
                                    </div>
                                    <a href="admin-menu-add.php" class="btn btn-primary">
                                        <i class="bx bx-plus me-1"></i>เพิ่มเมนู
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">รายการเมนู (<?php echo count($menus); ?>)</h5>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option selected>ทุกหมวดหมู่</option>
                                    <option>เมนูหลัก</option>
                                    <option>เครื่องดื่ม</option>
                                    <option>ของหวาน</option>
                                    <option>เมนูพิเศษ</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>รูปภาพ</th>
                                                <th>ชื่อเมนู</th>
                                                <th>หมวดหมู่</th>
                                                <th class="text-end">ราคา</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menus as $menu): ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo $menu['image']; ?>" alt="<?php echo $menu['name']; ?>" 
                                                            class="img-fluid avatar-sm rounded">
                                                    </td>
                                                    <td class="fw-semibold"><?php echo $menu['name']; ?></td>
                                                    <td><span class="badge badge-soft-primary"><?php echo $menu['category']; ?></span></td>
                                                    <td class="text-end fw-bold text-primary">฿<?php echo number_format($menu['price']); ?></td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <button class="btn btn-sm btn-soft-info" onclick="viewMenu(<?php echo $menu['id']; ?>)">
                                                                <i class="bx bx-show"></i>
                                                            </button>
                                                            <a href="admin-menu-add.php?id=<?php echo $menu['id']; ?>" class="btn btn-sm btn-soft-secondary">
                                                                <i class="bx bx-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-soft-danger" onclick="deleteMenu(<?php echo $menu['id']; ?>)">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
        function viewMenu(id) {
            alert('ดูรายละเอียดเมนู ID: ' + id);
        }
        
        function deleteMenu(id) {
            if (confirm('ต้องการลบเมนูนี้ใช่หรือไม่?')) {
                alert('ลบเมนู ID: ' + id + ' สำเร็จ');
                location.reload();
            }
        }
    </script>
</body>
</html>
