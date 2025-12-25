<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Payment";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .payment-method { flex-direction: column; }
            .payment-method .card { margin-bottom: 0.5rem; }
            .table-responsive { font-size: 0.875rem; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Payment";
        
        $tableId = isset($_GET['table']) ? $_GET['table'] : 2;
        $tableName = "โต๊ะ " . $tableId;
        
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
                                    <h4 class="mb-1">ชำระเงิน - <?php echo $tableName; ?></h4>
                                    <p class="text-muted mb-0">รับชำระเงินและปิดโต๊ะ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">รายการสั่งอาหาร</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>รายการ</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-end">ราคา/หน่วย</th>
                                                <th class="text-end">รวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderItems as $item): ?>
                                                <tr>
                                                    <td class="fw-semibold"><?php echo $item['name']; ?></td>
                                                    <td class="text-center"><?php echo $item['qty']; ?></td>
                                                    <td class="text-end">฿<?php echo number_format($item['price']); ?></td>
                                                    <td class="text-end fw-bold">฿<?php echo number_format($item['price'] * $item['qty']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="border-top pt-3 mt-3">
                                    <div class="row justify-content-end">
                                        <div class="col-md-6 col-lg-5">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>ยอดรวม</span>
                                                <span>฿<?php echo number_format($subtotal); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>ภาษี (7%)</span>
                                                <span>฿<?php echo number_format($tax); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between border-top pt-2">
                                                <h5 class="mb-0">ยอดชำระทั้งหมด</h5>
                                                <h4 class="text-primary mb-0">฿<?php echo number_format($total); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">วิธีชำระเงิน</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="cashPayment" value="cash" checked>
                                            <label class="form-check-label" for="cashPayment">
                                                <iconify-icon icon="solar:wallet-bold-duotone" class="fs-20 align-middle me-1"></iconify-icon>
                                                เงินสด
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="transferPayment" value="transfer">
                                            <label class="form-check-label" for="transferPayment">
                                                <iconify-icon icon="solar:card-transfer-bold-duotone" class="fs-20 align-middle me-1"></iconify-icon>
                                                โอนเงิน
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="cashSection" class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">รับเงินมา</label>
                                            <input type="number" class="form-control" id="cashReceived" placeholder="0" min="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">เงินทอน</label>
                                            <input type="text" class="form-control" id="changeAmount" placeholder="0" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div id="transferSection" class="mt-3" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">แนบหลักฐานการโอน</label>
                                            <input type="file" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">หมายเลขอ้างอิง (ถ้ามี)</label>
                                            <input type="text" class="form-control" placeholder="เช่น REF12345">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card sticky-top" style="top: 80px;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">สรุปการชำระเงิน</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>โต๊ะ</span>
                                    <span class="fw-bold"><?php echo $tableName; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>จำนวนรายการ</span>
                                    <span class="fw-bold"><?php echo count($orderItems); ?> รายการ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                    <span>วิธีชำระเงิน</span>
                                    <span class="badge badge-soft-primary" id="selectedMethod">เงินสด</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">ยอดชำระ</h5>
                                    <h4 class="text-primary mb-0">฿<?php echo number_format($total); ?></h4>
                                </div>
                                <button class="btn btn-success w-100 mb-2" id="confirmPayment">ยืนยันการชำระเงิน</button>
                                <a href="staff-dashboard.php" class="btn btn-outline-secondary w-100">ยกเลิก</a>
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
            var total = <?php echo $total; ?>;
            var cashSection = document.getElementById('cashSection');
            var transferSection = document.getElementById('transferSection');
            var cashReceived = document.getElementById('cashReceived');
            var changeAmount = document.getElementById('changeAmount');
            var selectedMethod = document.getElementById('selectedMethod');

            document.querySelectorAll('input[name="paymentMethod"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.value === 'cash') {
                        cashSection.style.display = 'block';
                        transferSection.style.display = 'none';
                        selectedMethod.textContent = 'เงินสด';
                    } else {
                        cashSection.style.display = 'none';
                        transferSection.style.display = 'block';
                        selectedMethod.textContent = 'โอนเงิน';
                    }
                });
            });

            cashReceived.addEventListener('input', function() {
                var received = parseFloat(this.value) || 0;
                var change = received - total;
                changeAmount.value = change >= 0 ? '฿' + change.toFixed(0) : '฿0';
            });

            document.getElementById('confirmPayment').addEventListener('click', function() {
                var method = document.querySelector('input[name="paymentMethod"]:checked').value;
                if (method === 'cash') {
                    var received = parseFloat(cashReceived.value) || 0;
                    if (received < total) {
                        alert('รับเงินมาไม่เพียงพอ กรุณาตรวจสอบจำนวนเงิน');
                        return;
                    }
                }
                if (confirm('ยืนยันการชำระเงินและปิดโต๊ะ?')) {
                    alert('ชำระเงินสำเร็จ กำลังสร้างใบเสร็จ...');
                    window.location.href = 'staff-receipt.php?table=<?php echo $tableId; ?>';
                }
            });
        })();
    </script>
</body>
</html>
