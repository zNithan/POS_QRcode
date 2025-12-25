<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Receipt";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media print {
            .no-print { display: none; }
            .receipt-print { max-width: 80mm; margin: 0 auto; }
        }
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .receipt-print { padding: 0.5rem; }
            .table-responsive { font-size: 0.875rem; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Receipt";
        
        $receiptNo = 'RCP-' . date('Ymd') . '-' . rand(1000, 9999);
        $tableId = isset($_GET['table']) ? $_GET['table'] : 2;
        $tableName = "โต๊ะ " . $tableId;
        $dateTime = date('d/m/Y H:i');
        
        $orderItems = [
            ['name' => 'ข้าวกะเพราไก่', 'qty' => 2, 'price' => 120],
            ['name' => 'ลาเต้เย็น', 'qty' => 2, 'price' => 70],
            ['name' => 'ต้มยำกุ้ง', 'qty' => 1, 'price' => 180],
        ];
        
        $subtotal = 0;
        foreach ($orderItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.07;
        $total = $subtotal + $tax;
        $paymentMethod = 'เงินสด';

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12 no-print">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                                <a href="staff-dashboard.php" class="btn btn-soft-secondary"><i class="bx bx-arrow-back"></i></a>
                                <div>
                                    <h4 class="mb-1">ใบเสร็จรับเงิน</h4>
                                    <p class="text-muted mb-0">พิมพ์หรือบันทึกใบเสร็จ</p>
                                </div>
                                <div class="ms-auto d-flex gap-2">
                                    <button class="btn btn-primary" onclick="window.print()"><i class="bx bx-printer me-1"></i>พิมพ์ใบเสร็จ</button>
                                    <button class="btn btn-soft-secondary" onclick="window.print()"><i class="bx bx-copy me-1"></i>พิมพ์ซ้ำ</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center">
                        <div class="card" style="max-width: 600px; width: 100%;">
                            <div class="card-body receipt-print p-4">
                                <div class="text-center mb-4">
                                    <h3 class="mb-1">ร้านอาหารของเรา</h3>
                                    <p class="text-muted mb-0">123 ถนนสุขุมวิท กรุงเทพฯ 10110</p>
                                    <p class="text-muted mb-0">โทร: 02-123-4567</p>
                                    <p class="text-muted mb-0">TAX ID: 0-1234-56789-01-2</p>
                                </div>

                                <div class="border-top border-bottom py-3 mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-1"><strong>เลขที่:</strong> <?php echo $receiptNo; ?></p>
                                            <p class="mb-1"><strong>โต๊ะ:</strong> <?php echo $tableName; ?></p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="mb-1"><strong>วันที่:</strong> <?php echo $dateTime; ?></p>
                                            <p class="mb-1"><strong>พนักงาน:</strong> Staff01</p>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-3">รายการอาหาร</h5>
                                <table class="table table-borderless mb-3">
                                    <thead>
                                        <tr class="border-bottom">
                                            <th>รายการ</th>
                                            <th class="text-center">จำนวน</th>
                                            <th class="text-end">ราคา</th>
                                            <th class="text-end">รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItems as $item): ?>
                                            <tr>
                                                <td><?php echo $item['name']; ?></td>
                                                <td class="text-center"><?php echo $item['qty']; ?></td>
                                                <td class="text-end">฿<?php echo number_format($item['price']); ?></td>
                                                <td class="text-end">฿<?php echo number_format($item['price'] * $item['qty']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>ยอดรวม</span>
                                        <span>฿<?php echo number_format($subtotal); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>ภาษี 7%</span>
                                        <span>฿<?php echo number_format($tax); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-2 mb-3">
                                        <h5 class="mb-0">ยอดชำระทั้งหมด</h5>
                                        <h4 class="mb-0 text-primary">฿<?php echo number_format($total); ?></h4>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>วิธีชำระเงิน:</span>
                                        <span class="badge badge-soft-success"><?php echo $paymentMethod; ?></span>
                                    </div>
                                </div>

                                <div class="text-center mt-4 pt-3 border-top">
                                    <p class="text-muted mb-1">ขอบคุณที่ใช้บริการ</p>
                                    <p class="text-muted mb-0">www.restaurant.com</p>
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
