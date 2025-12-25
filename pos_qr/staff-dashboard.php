<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Staff Dashboard";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .table-card { overflow-x: auto; }
            .d-none-mobile { display: none !important; }
        }
        @media (max-width: 576px) {
            .text-truncate-mobile { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Staff Dashboard";
        
        // Mock data - Replace with DB later
        $tables = [
            ['id' => 1, 'name' => 'โต๊ะ 1', 'status' => 'available', 'guests' => 0, 'amount' => 0],
            ['id' => 2, 'name' => 'โต๊ะ 2', 'status' => 'occupied', 'guests' => 4, 'amount' => 850],
            ['id' => 3, 'name' => 'โต๊ะ 3', 'status' => 'pending', 'guests' => 2, 'amount' => 420],
            ['id' => 4, 'name' => 'โต๊ะ 4', 'status' => 'available', 'guests' => 0, 'amount' => 0],
            ['id' => 5, 'name' => 'โต๊ะ 5', 'status' => 'occupied', 'guests' => 6, 'amount' => 1250],
            ['id' => 6, 'name' => 'โต๊ะ 6', 'status' => 'available', 'guests' => 0, 'amount' => 0],
            ['id' => 7, 'name' => 'โต๊ะ 7', 'status' => 'pending', 'guests' => 3, 'amount' => 680],
            ['id' => 8, 'name' => 'โต๊ะ 8', 'status' => 'occupied', 'guests' => 2, 'amount' => 540],
        ];

        $activeOrders = [
            ['table' => 'โต๊ะ 2', 'items' => 5, 'status' => 'cooking', 'time' => '10 นาที'],
            ['table' => 'โต๊ะ 5', 'items' => 8, 'status' => 'ready', 'time' => '2 นาที'],
            ['table' => 'โต๊ะ 8', 'items' => 3, 'status' => 'waiting', 'time' => 'เพิ่งสั่ง'],
        ];

        $statusConfig = [
            'available' => ['label' => 'ว่าง', 'color' => 'success', 'icon' => 'solar:check-circle-bold-duotone'],
            'occupied' => ['label' => 'มีลูกค้า', 'color' => 'warning', 'icon' => 'solar:user-bold-duotone'],
            'pending' => ['label' => 'รอชำระเงิน', 'color' => 'danger', 'icon' => 'solar:wallet-bold-duotone'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                    <div>
                                        <h4 class="mb-1">พนักงานหน้าร้าน</h4>
                                        <p class="text-muted mb-0">จัดการโต๊ะ ออเดอร์ และการชำระเงิน</p>
                                    </div>
                                    <div class="ms-auto d-flex flex-wrap gap-2">
                                        <a href="staff-add-order.php" class="btn btn-primary d-flex align-items-center">
                                            <i class="bx bx-plus me-1"></i>เพิ่มออเดอร์
                                        </a>
                                        <a href="staff-qr-code.php" class="btn btn-soft-secondary d-flex align-items-center">
                                            <i class="bx bx-qr me-1"></i>พิมพ์ QR Code
                                        </a>
                                        <a href="staff-register-member.php" class="btn btn-soft-info d-flex align-items-center">
                                            <i class="bx bx-user-plus me-1"></i>ลงทะเบียนสมาชิก
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">สถานะโต๊ะทั้งหมด</h5>
                                <div class="d-flex gap-2">
                                    <span class="badge badge-soft-success">ว่าง: <?php echo count(array_filter($tables, fn($t) => $t['status'] === 'available')); ?></span>
                                    <span class="badge badge-soft-warning">มีลูกค้า: <?php echo count(array_filter($tables, fn($t) => $t['status'] === 'occupied')); ?></span>
                                    <span class="badge badge-soft-danger">รอชำระ: <?php echo count(array_filter($tables, fn($t) => $t['status'] === 'pending')); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                                    <?php foreach ($tables as $table): 
                                        $config = $statusConfig[$table['status']];
                                    ?>
                                        <div class="col">
                                            <div class="card border border-<?php echo $config['color']; ?> mb-0 h-100">
                                                <div class="card-body text-center">
                                                    <iconify-icon icon="<?php echo $config['icon']; ?>" class="fs-32 text-<?php echo $config['color']; ?>"></iconify-icon>
                                                    <h5 class="mt-2 mb-1"><?php echo $table['name']; ?></h5>
                                                    <span class="badge badge-soft-<?php echo $config['color']; ?> mb-2"><?php echo $config['label']; ?></span>
                                                    <?php if ($table['status'] !== 'available'): ?>
                                                        <p class="text-muted mb-1"><small>จำนวนคน: <?php echo $table['guests']; ?></small></p>
                                                        <p class="fw-bold text-primary mb-2">฿ <?php echo number_format($table['amount']); ?></p>
                                                    <?php endif; ?>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <?php if ($table['status'] === 'available'): ?>
                                                            <a href="staff-add-order.php?table=<?php echo $table['id']; ?>" class="btn btn-sm btn-primary">เปิดโต๊ะ</a>
                                                        <?php elseif ($table['status'] === 'occupied'): ?>
                                                            <a href="staff-order-list.php?table=<?php echo $table['id']; ?>" class="btn btn-sm btn-soft-secondary">ดูออเดอร์</a>
                                                            <a href="staff-payment.php?table=<?php echo $table['id']; ?>" class="btn btn-sm btn-success">ชำระเงิน</a>
                                                        <?php elseif ($table['status'] === 'pending'): ?>
                                                            <a href="staff-payment.php?table=<?php echo $table['id']; ?>" class="btn btn-sm btn-danger">ชำระเงิน</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">ออเดอร์ที่กำลังดำเนินการ</h5>
                                <a href="staff-order-list.php" class="btn btn-sm btn-soft-primary">ดูทั้งหมด</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>โต๊ะ</th>
                                                <th>จำนวนรายการ</th>
                                                <th>สถานะ</th>
                                                <th>เวลา</th>
                                                <th>การดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($activeOrders as $order): ?>
                                                <tr>
                                                    <td class="fw-semibold"><?php echo $order['table']; ?></td>
                                                    <td><?php echo $order['items']; ?> รายการ</td>
                                                    <td>
                                                        <?php 
                                                        $orderStatus = ['waiting' => ['label' => 'รอทำ', 'color' => 'warning'], 'cooking' => ['label' => 'กำลังทำ', 'color' => 'info'], 'ready' => ['label' => 'พร้อมเสิร์ฟ', 'color' => 'success']];
                                                        $status = $orderStatus[$order['status']];
                                                        ?>
                                                        <span class="badge badge-soft-<?php echo $status['color']; ?>"><?php echo $status['label']; ?></span>
                                                    </td>
                                                    <td><?php echo $order['time']; ?></td>
                                                    <td>
                                                        <a href="staff-order-list.php" class="btn btn-sm btn-soft-secondary"><i class="bx bx-show"></i> ดู</a>
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
</body>
</html>
