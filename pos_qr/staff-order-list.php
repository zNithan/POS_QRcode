<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Order List";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            h6 { font-size: 0.9rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .badge { font-size: 0.7rem; }
            .list-group-item { padding: 0.5rem 0.75rem; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Order List";
        
        $orders = [
            ['table' => 'โต๊ะ 2', 'items' => [
                ['name' => 'ข้าวกะเพราไก่', 'qty' => 2, 'price' => 120, 'status' => 'cooking'],
                ['name' => 'ลาเต้เย็น', 'qty' => 2, 'price' => 70, 'status' => 'ready'],
                ['name' => 'ต้มยำกุ้ง', 'qty' => 1, 'price' => 180, 'status' => 'cooking'],
            ]],
            ['table' => 'โต๊ะ 5', 'items' => [
                ['name' => 'สเต็กแซลมอน', 'qty' => 2, 'price' => 320, 'status' => 'ready'],
                ['name' => 'ซีซาร์สลัด', 'qty' => 3, 'price' => 110, 'status' => 'ready'],
                ['name' => 'มอคค่าเย็น', 'qty' => 3, 'price' => 75, 'status' => 'ready'],
            ]],
            ['table' => 'โต๊ะ 8', 'items' => [
                ['name' => 'ผัดไทยกุ้งสด', 'qty' => 2, 'price' => 150, 'status' => 'waiting'],
                ['name' => 'ชาเขียวเย็น', 'qty' => 1, 'price' => 60, 'status' => 'waiting'],
            ]],
        ];

        $statusConfig = [
            'waiting' => ['label' => 'รอทำ', 'color' => 'warning'],
            'cooking' => ['label' => 'กำลังทำ', 'color' => 'info'],
            'ready' => ['label' => 'พร้อมเสิร์ฟ', 'color' => 'success'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                                <a href="staff-dashboard.php" class="btn btn-soft-secondary"><i class="bx bx-arrow-back"></i></a>
                                <div>
                                    <h4 class="mb-1">รายการออเดอร์ปัจจุบัน</h4>
                                    <p class="text-muted mb-0">ดูและจัดการออเดอร์แยกตามโต๊ะ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($orders as $order): 
                        $tableTotal = 0;
                        foreach ($order['items'] as $item) {
                            $tableTotal += $item['price'] * $item['qty'];
                        }
                    ?>
                        <div class="col-xl-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0"><?php echo $order['table']; ?></h5>
                                    <div class="d-flex gap-2">
                                        <a href="staff-add-order.php?table=<?php echo substr($order['table'], -1); ?>" class="btn btn-sm btn-soft-secondary">เพิ่มรายการ</a>
                                        <a href="staff-payment.php?table=<?php echo substr($order['table'], -1); ?>" class="btn btn-sm btn-success">ชำระเงิน</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-centered">
                                        <table class="table text-nowrap mb-0">
                                            <thead class="bg-light bg-opacity-50">
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th class="text-center">จำนวน</th>
                                                    <th>สถานะ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($order['items'] as $item): ?>
                                                    <tr>
                                                        <td>
                                                            <h6 class="mb-0"><?php echo $item['name']; ?></h6>
                                                            <small class="text-muted">฿<?php echo number_format($item['price']); ?></small>
                                                        </td>
                                                        <td class="text-center"><?php echo $item['qty']; ?></td>
                                                        <td>
                                                            <?php 
                                                            $config = $statusConfig[$item['status']];
                                                            ?>
                                                            <span class="badge badge-soft-<?php echo $config['color']; ?>"><?php echo $config['label']; ?></span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-soft-danger" onclick="if(confirm('ยกเลิกรายการนี้?')) alert('ยกเลิกแล้ว')"><i class="bx bx-x"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="border-top pt-3 mt-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">ยอดรวม</h6>
                                            <h5 class="text-primary mb-0">฿ <?php echo number_format($tableTotal); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <?php include "partials/footer.php" ?>
        </div>
    </div>

    <?php include 'partials/vendor-scripts.php' ?>
</body>
</html>
