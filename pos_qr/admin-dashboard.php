<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Administrator Dashboard";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Administrator Dashboard";
        
        // Mock data - Replace with DB queries
        $stats = [
            ['label' => 'เมนูอาหาร', 'value' => 48, 'icon' => 'solar:cup-hot-bold-duotone', 'color' => 'primary', 'link' => 'admin-menu-list.php'],
            ['label' => 'หมวดหมู่', 'value' => 8, 'icon' => 'solar:tag-bold-duotone', 'color' => 'success', 'link' => 'admin-categories.php'],
            ['label' => 'โต๊ะ', 'value' => 12, 'icon' => 'solar:chair-bold-duotone', 'color' => 'warning', 'link' => 'admin-tables.php'],
            ['label' => 'วัตถุดิบ', 'value' => 35, 'icon' => 'solar:box-bold-duotone', 'color' => 'info', 'link' => 'inventory-stock.php'],
            ['label' => 'สมาชิก', 'value' => 284, 'icon' => 'solar:users-group-rounded-bold-duotone', 'color' => 'purple', 'link' => 'admin-members.php'],
            ['label' => 'ผู้ใช้งาน', 'value' => 12, 'icon' => 'solar:user-id-bold-duotone', 'color' => 'orange', 'link' => 'admin-users.php'],
        ];

        $recentActivities = [
            ['action' => 'เพิ่มเมนูใหม่', 'item' => 'ข้าวผัดกุ้ง', 'user' => 'Admin01', 'time' => '5 นาทีที่แล้ว'],
            ['action' => 'แก้ไขราคา', 'item' => 'สเต็กแซลมอน', 'user' => 'Admin01', 'time' => '15 นาทีที่แล้ว'],
            ['action' => 'เพิ่มวัตถุดิบ', 'item' => 'เนื้อไก่ 5 กก.', 'user' => 'Staff03', 'time' => '1 ชั่วโมงที่แล้ว'],
            ['action' => 'ลบโต๊ะ', 'item' => 'โต๊ะ 15', 'user' => 'Admin02', 'time' => '2 ชั่วโมงที่แล้ว'],
        ];

        $lowStockItems = [
            ['name' => 'เนื้อหมูสันใน', 'qty' => 1.8, 'unit' => 'กก.', 'status' => 'critical'],
            ['name' => 'อกไก่', 'qty' => 6.4, 'unit' => 'กก.', 'status' => 'low'],
            ['name' => 'น้ำปลา', 'qty' => 9, 'unit' => 'ขวด', 'status' => 'low'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <div>
                                        <h4 class="mb-1">ระบบผู้ดูแล</h4>
                                        <p class="text-muted mb-0">จัดการข้อมูลหลักและตั้งค่าระบบ POS</p>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge badge-soft-success">
                                            <i class="bx bx-check-circle me-1"></i>ระบบพร้อมใช้งาน
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <?php foreach ($stats as $stat): ?>
                                <div class="col">
                                    <a href="<?php echo $stat['link']; ?>" class="text-decoration-none">
                                        <div class="card h-100 card-hover">
                                            <div class="card-body overflow-hidden position-relative">
                                                <iconify-icon icon="<?php echo $stat['icon']; ?>" class="fs-36 text-<?php echo $stat['color']; ?>"></iconify-icon>
                                                <h3 class="mb-0 fw-bold mt-3"><?php echo $stat['value']; ?></h3>
                                                <p class="text-muted mb-0"><?php echo $stat['label']; ?></p>
                                                <i class='bx bx-doughnut-chart widget-icon'></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">การดำเนินการล่าสุด</h5>
                                <span class="badge badge-soft-primary">24 ชั่วโมง</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>การดำเนินการ</th>
                                                <th>รายการ</th>
                                                <th>ผู้ใช้งาน</th>
                                                <th>เวลา</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentActivities as $activity): ?>
                                                <tr>
                                                    <td><span class="badge badge-soft-info"><?php echo $activity['action']; ?></span></td>
                                                    <td class="fw-semibold"><?php echo $activity['item']; ?></td>
                                                    <td><?php echo $activity['user']; ?></td>
                                                    <td class="text-muted"><?php echo $activity['time']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">แจ้งเตือนสต็อก</h5>
                                <a href="inventory-stock.php" class="btn btn-sm btn-soft-danger">ดูทั้งหมด</a>
                            </div>
                            <div class="card-body">
                                <?php foreach ($lowStockItems as $item): ?>
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0 me-3">
                                            <iconify-icon icon="solar:danger-circle-bold-duotone" 
                                                class="fs-32 text-<?php echo $item['status'] === 'critical' ? 'danger' : 'warning'; ?>"></iconify-icon>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                                            <p class="text-muted mb-0">คงเหลือ: <?php echo $item['qty']; ?> <?php echo $item['unit']; ?></p>
                                        </div>
                                        <span class="badge badge-soft-<?php echo $item['status'] === 'critical' ? 'danger' : 'warning'; ?>">
                                            <?php echo $item['status'] === 'critical' ? 'วิกฤต' : 'ต่ำ'; ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">เมนูจัดการด่วน</h5>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                                    <div class="col">
                                        <a href="admin-menu-add.php" class="btn btn-soft-primary w-100 py-3">
                                            <i class="bx bx-plus-circle fs-24 d-block mb-2"></i>
                                            เพิ่มเมนูอาหาร
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="admin-categories.php" class="btn btn-soft-success w-100 py-3">
                                            <i class="bx bx-category fs-24 d-block mb-2"></i>
                                            จัดการหมวดหมู่
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="admin-tables.php" class="btn btn-soft-warning w-100 py-3">
                                            <i class="bx bx-grid-alt fs-24 d-block mb-2"></i>
                                            จัดการโต๊ะ
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="admin-users.php" class="btn btn-soft-info w-100 py-3">
                                            <i class="bx bx-user-plus fs-24 d-block mb-2"></i>
                                            จัดการผู้ใช้งาน
                                        </a>
                                    </div>
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
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
    </style>
</body>
</html>
