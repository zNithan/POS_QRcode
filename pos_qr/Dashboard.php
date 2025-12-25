<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Reports & Analytics";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">

        <?php 
        $subTitle = "Reports & Analytics";
        // Mock data (replace with DB/API later)
        $kpiCards = [
            ['label' => 'รายได้รวม', 'value' => '฿ 124,500', 'change' => '+8.6%', 'tone' => 'success', 'icon' => 'solar:wallet-2-bold-duotone'],
            ['label' => 'กำไรประมาณการ', 'value' => '฿ 38,200', 'change' => '+4.1%', 'tone' => 'success', 'icon' => 'solar:chart-2-bold-duotone'],
            ['label' => 'ออเดอร์ทั้งหมด', 'value' => '1,284', 'change' => '+12.3%', 'tone' => 'success', 'icon' => 'solar:bag-3-bold-duotone'],
            ['label' => 'สมาชิกใหม่', 'value' => '184', 'change' => '+5.0%', 'tone' => 'success', 'icon' => 'solar:users-group-rounded-bold-duotone'],
        ];

        $salesSeries = [
            'daily' => [12000, 14250, 9000, 16200, 17500, 18900, 21000],
            'weekly' => [84500, 79200, 91000, 88000],
            'monthly' => [320000, 295000, 310000, 355000, 380000, 365000],
        ];

        $salesCategories = [
            'daily' => ['จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.', 'อา.'],
            'weekly' => ['สัปดาห์ 1', 'สัปดาห์ 2', 'สัปดาห์ 3', 'สัปดาห์ 4'],
            'monthly' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
        ];

        $topMenus = [
            ['name' => 'ข้าวกะเพราไก่ไข่ดาว', 'qty' => 320, 'revenue' => '฿ 42,800', 'badge' => 'ฮิต'],
            ['name' => 'สเต็กแซลมอน', 'qty' => 210, 'revenue' => '฿ 63,000', 'badge' => 'Top'],
            ['name' => 'ส้มตำไทย', 'qty' => 260, 'revenue' => '฿ 20,800', 'badge' => 'ฮิต'],
            ['name' => 'ต้มยำกุ้ง', 'qty' => 185, 'revenue' => '฿ 37,000', 'badge' => 'เชฟแนะนำ'],
            ['name' => 'ผัดไทยกุ้งสด', 'qty' => 170, 'revenue' => '฿ 27,200', 'badge' => 'เชฟแนะนำ'],
            ['name' => 'ลาเต้เย็น', 'qty' => 410, 'revenue' => '฿ 28,700', 'badge' => 'เครื่องดื่ม'],
            ['name' => 'มอคค่าเย็น', 'qty' => 360, 'revenue' => '฿ 26,100', 'badge' => 'เครื่องดื่ม'],
            ['name' => 'ข้าวมันไก่', 'qty' => 240, 'revenue' => '฿ 26,400', 'badge' => 'เมนูหลัก'],
            ['name' => 'ซีซาร์สลัด', 'qty' => 150, 'revenue' => '฿ 18,000', 'badge' => 'สุขภาพ'],
            ['name' => 'ไก่ทอดซอสเกาหลี', 'qty' => 130, 'revenue' => '฿ 23,400', 'badge' => 'เมนูใหม่'],
        ];

        $ingredientUsage = [
            ['name' => 'อกไก่', 'amount' => '48', 'unit' => 'กก.', 'period' => 'สัปดาห์นี้'],
            ['name' => 'เนื้อหมูสันใน', 'amount' => '32', 'unit' => 'กก.', 'period' => 'สัปดาห์นี้'],
            ['name' => 'เส้นจันทน์', 'amount' => '85', 'unit' => 'แพ็ก', 'period' => 'เดือนนี้'],
            ['name' => 'ผักสลัด', 'amount' => '60', 'unit' => 'แพ็ก', 'period' => 'เดือนนี้'],
            ['name' => 'นมข้นจืด', 'amount' => '40', 'unit' => 'ลิตร', 'period' => 'เดือนนี้'],
        ];

        $members = [
            ['name' => 'คุณอารีย์', 'tier' => 'Gold', 'orders' => 42, 'spend' => '฿ 18,500'],
            ['name' => 'คุณภาสกร', 'tier' => 'Silver', 'orders' => 35, 'spend' => '฿ 12,800'],
            ['name' => 'คุณญาดา', 'tier' => 'Platinum', 'orders' => 58, 'spend' => '฿ 31,200'],
            ['name' => 'คุณชัยวัฒน์', 'tier' => 'Gold', 'orders' => 40, 'spend' => '฿ 17,900'],
            ['name' => 'คุณเอมอร', 'tier' => 'Silver', 'orders' => 26, 'spend' => '฿ 9,200'],
        ];

        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
                    <?php foreach ($kpiCards as $card): ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body overflow-hidden position-relative">
                                    <iconify-icon icon="<?php echo $card['icon']; ?>" class="fs-32 text-primary"></iconify-icon>
                                    <h4 class="fw-bold mt-3 mb-1"><?php echo $card['value']; ?></h4>
                                    <p class="text-muted mb-2"><?php echo $card['label']; ?></p>
                                    <span class="badge fs-12 badge-soft-<?php echo $card['tone']; ?>">
                                        <i class="ti ti-arrow-badge-up"></i> <?php echo $card['change']; ?>
                                    </span>
                                    <i class='bx bx-doughnut-chart widget-icon'></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-xxl-8">
                        <div class="card h-100">
                            <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1">Sales Summary</h4>
                                    <p class="text-muted mb-0">ยอดขายรวมและจำนวนออเดอร์ แยกตามช่วงเวลา</p>
                                </div>
                                <div class="btn-group" role="group" aria-label="Sales timeframe">
                                    <button type="button" class="btn btn-sm btn-soft-secondary active" data-range="daily">รายวัน</button>
                                    <button type="button" class="btn btn-sm btn-soft-secondary" data-range="weekly">รายสัปดาห์</button>
                                    <button type="button" class="btn btn-sm btn-soft-secondary" data-range="monthly">รายเดือน</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    <div>
                                        <p class="text-muted mb-1">ยอดขายรวม</p>
                                        <h4 class="mb-0">฿ <span id="sales-total">124,500</span></h4>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1">จำนวนออเดอร์</p>
                                        <h4 class="mb-0"><span id="orders-total">1,284</span> ออเดอร์</h4>
                                    </div>
                                </div>
                                <div id="sales-summary-chart" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">เมนูขายดี 10 อันดับ</h4>
                                <span class="badge badge-soft-primary">สัปดาห์นี้</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>เมนู</th>
                                                <th class="text-end">จำนวน</th>
                                                <th class="text-end">ยอดขาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($topMenus as $menu): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="badge badge-soft-success"><?php echo $menu['badge']; ?></span>
                                                            <span class="fw-semibold text-dark"><?php echo $menu['name']; ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-end"><?php echo number_format($menu['qty']); ?></td>
                                                    <td class="text-end"><?php echo $menu['revenue']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-xl-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">รายงานการใช้วัตถุดิบ</h4>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="date" class="form-control form-control-sm" style="max-width: 160px;" aria-label="start date">
                                    <input type="date" class="form-control form-control-sm" style="max-width: 160px;" aria-label="end date">
                                    <button class="btn btn-sm btn-primary">กรอง</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>วัตถุดิบ</th>
                                                <th class="text-end">ปริมาณ</th>
                                                <th>หน่วย</th>
                                                <th>ช่วงเวลา</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ingredientUsage as $item): ?>
                                                <tr>
                                                    <td class="fw-semibold text-dark"><?php echo $item['name']; ?></td>
                                                    <td class="text-end"><?php echo $item['amount']; ?></td>
                                                    <td><?php echo $item['unit']; ?></td>
                                                    <td><span class="badge badge-soft-info"><?php echo $item['period']; ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">รายงานสมาชิก</h4>
                                <div class="d-flex gap-2 align-items-center">
                                    <select class="form-select form-select-sm" style="max-width: 160px;">
                                        <option selected>ช่วง 30 วัน</option>
                                        <option>ไตรมาสนี้</option>
                                        <option>ปีนี้</option>
                                    </select>
                                    <button class="btn btn-sm btn-soft-secondary">Export</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-4 mb-3">
                                    <div>
                                        <p class="text-muted mb-1">สมาชิกทั้งหมด</p>
                                        <h5 class="mb-0"><?php echo number_format(3280); ?> คน</h5>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1">สมาชิกใหม่ (30 วัน)</p>
                                        <h5 class="mb-0 text-success">+184</h5>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1">Top Tier</p>
                                        <h5 class="mb-0 text-primary">Platinum / Gold</h5>
                                    </div>
                                </div>
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>ชื่อ</th>
                                                <th>ระดับ</th>
                                                <th class="text-end">ออเดอร์</th>
                                                <th class="text-end">ยอดใช้จ่าย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($members as $member): ?>
                                                <tr>
                                                    <td class="fw-semibold text-dark"><?php echo $member['name']; ?></td>
                                                    <td><span class="badge badge-soft-primary"><?php echo $member['tier']; ?></span></td>
                                                    <td class="text-end"><?php echo number_format($member['orders']); ?></td>
                                                    <td class="text-end"><?php echo $member['spend']; ?></td>
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
        (function () {
            var salesSeries = <?php echo json_encode($salesSeries); ?>;
            var salesCategories = <?php echo json_encode($salesCategories); ?>;
            var chartEl = document.querySelector('#sales-summary-chart');
            var activeRange = 'daily';

            function makeOptions(rangeKey) {
                return {
                    chart: { type: 'line', height: 320, toolbar: { show: false } },
                    stroke: { width: 3, curve: 'smooth' },
                    colors: ['#4a8aff'],
                    dataLabels: { enabled: false },
                    series: [{ name: 'ยอดขาย', data: salesSeries[rangeKey] || [] }],
                    xaxis: { categories: salesCategories[rangeKey] || [], axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { labels: { formatter: function (val) { return val >= 1000 ? (val/1000).toFixed(1) + 'k' : val; } } },
                    grid: { borderColor: 'rgba(99, 115, 129, 0.15)' },
                    tooltip: { shared: true }
                };
            }

            var salesChart = chartEl ? new ApexCharts(chartEl, makeOptions(activeRange)) : null;
            if (salesChart) { salesChart.render(); }

            document.querySelectorAll('[data-range]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var range = this.getAttribute('data-range');
                    if (!range || !salesChart) return;
                    activeRange = range;
                    document.querySelectorAll('[data-range]').forEach(function (b) { b.classList.remove('active'); });
                    this.classList.add('active');
                    salesChart.updateOptions(makeOptions(range));
                });
            });
        })();
    </script>
</body>

</html>
