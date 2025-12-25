<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Inventory Stock";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <!-- START Wrapper -->
    <div class="wrapper">

        <?php 
        $subTitle = "Inventory Stock";
        $pageNotifications = [
            [
                'title' => 'สต็อกต่ำกว่ากำหนด: เนื้อหมูสันใน',
                'message' => 'เหลือ 1.8 กก. ต่ำกว่า 20% ของสต็อก',
                'tone' => 'danger',
                'icon' => 'solar:bell-bing-bold-duotone',
                'time' => 'อัปเดต 5 นาทีที่แล้ว'
            ],
            [
                'title' => 'ใกล้หมด: อกไก่',
                'message' => 'เหลือ 6.4 กก. ต่ำกว่า 30% ของสต็อก',
                'tone' => 'warning',
                'icon' => 'solar:bell-bing-bold-duotone',
                'time' => 'อัปเดต 10 นาทีที่แล้ว'
            ],
            [
                'title' => 'การเพิ่มสต็อกสำเร็จ',
                'message' => 'เพิ่มซอสหอยนางรม 12 ขวด โดยผู้จัดการครัว',
                'tone' => 'success',
                'icon' => 'solar:check-circle-bold-duotone',
                'time' => 'วันนี้ 09:45'
            ],
        ];
        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-xxl">

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-3 align-items-center">
                                <div>
                                    <h4 class="mb-1">สต็อกวัตถุดิบ</h4>
                                    <p class="text-muted mb-0">ภาพรวมวัตถุดิบสำหรับร้านอาหาร พร้อมแจ้งเตือนและประวัติการทำรายการ</p>
                                </div>
                                <div class="ms-auto d-flex flex-wrap gap-2">
                                    <div class="search-bar">
                                        <span><i class="bx bx-search-alt"></i></span>
                                        <input type="search" class="form-control" placeholder="ค้นหาวัตถุดิบ...">
                                    </div>
                                    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addStockModal">
                                        <i class="bx bx-plus me-1"></i>เพิ่มสต็อกวัตถุดิบ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">กรองข้อมูล</h5>
                                <div class="mb-3">
                                    <label class="form-label">หมวดหมู่</label>
                                    <select class="form-select">
                                        <option selected>ทั้งหมด</option>
                                        <option>เนื้อสัตว์</option>
                                        <option>ผัก</option>
                                        <option>เครื่องปรุง</option>
                                        <option>วัตถุดิบสด</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">สถานะสต็อก</label>
                                    <select class="form-select">
                                        <option selected>ทั้งหมด</option>
                                        <option value="normal">ปกติ</option>
                                        <option value="low">ใกล้หมด</option>
                                        <option value="critical">ต่ำกว่ากำหนด</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ช่วงวันที่ (ประวัติ)</label>
                                    <input type="date" class="form-control mb-2" placeholder="จาก">
                                    <input type="date" class="form-control" placeholder="ถึง">
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" class="btn btn-outline-primary w-100">ล้างค่า</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" class="btn btn-primary w-100">นำไปใช้</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                    <h5 class="card-title mb-0">สถานะสต็อก</h5>
                                    <span class="badge badge-soft-warning ms-auto d-inline-flex align-items-center"><i class="bx bx-bell me-1"></i>มีวัตถุดิบใกล้หมด</span>
                                </div>
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>วัตถุดิบ</th>
                                                <th>หมวดหมู่</th>
                                                <th class="text-end">คงเหลือ</th>
                                                <th>หน่วย</th>
                                                <th>สถานะ</th>
                                                <th>แจ้งเตือน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">เนื้อหมูสันใน</h6>
                                                            <small class="text-muted">อัปเดตล่าสุด: 12/03/2025</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>เนื้อสัตว์</td>
                                                <td class="text-end">1.8</td>
                                                <td>กิโลกรัม</td>
                                                <td><span class="badge badge-soft-danger">ต่ำกว่ากำหนด</span></td>
                                                <td class="text-danger">เหลือ 1.8 กิโลกรัม ต่ำกว่า 20% ของสต็อก</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">อกไก่</h6>
                                                            <small class="text-muted">อัปเดตล่าสุด: 12/03/2025</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>เนื้อสัตว์</td>
                                                <td class="text-end">6.4</td>
                                                <td>กิโลกรัม</td>
                                                <td><span class="badge badge-soft-warning">ใกล้หมด</span></td>
                                                <td class="text-warning">เหลือ 6.4 กิโลกรัม ต่ำกว่า 30%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">ผักโขม</h6>
                                                            <small class="text-muted">อัปเดตล่าสุด: 11/03/2025</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>ผัก</td>
                                                <td class="text-end">12</td>
                                                <td>แพ็ก</td>
                                                <td><span class="badge badge-soft-success">ปกติ</span></td>
                                                <td class="text-muted">-</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">ซอสหอยนางรม</h6>
                                                            <small class="text-muted">อัปเดตล่าสุด: 10/03/2025</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>เครื่องปรุง</td>
                                                <td class="text-end">18</td>
                                                <td>ขวด</td>
                                                <td><span class="badge badge-soft-success">ปกติ</span></td>
                                                <td class="text-muted">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#report-tab" role="tab">รายงานสต็อก</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#history-tab" role="tab">ประวัติการเพิ่มสต็อก</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#order-tab" role="tab">ประวัติออเดอร์</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="report-tab" role="tabpanel">
                                        <div class="table-responsive table-centered">
                                            <table class="table text-nowrap mb-0">
                                                <thead class="bg-light bg-opacity-50">
                                                    <tr>
                                                        <th>วัตถุดิบ</th>
                                                        <th>หมวดหมู่</th>
                                                        <th class="text-end">คงเหลือ</th>
                                                        <th>หน่วย</th>
                                                        <th>ขั้นต่ำที่ตั้งไว้</th>
                                                        <th>สถานะ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>แซลมอน</td>
                                                        <td>เนื้อสัตว์</td>
                                                        <td class="text-end">4.2</td>
                                                        <td>กิโลกรัม</td>
                                                        <td>3 กก.</td>
                                                        <td><span class="badge badge-soft-warning">ใกล้หมด</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>เห็ดออรินจิ</td>
                                                        <td>ผัก</td>
                                                        <td class="text-end">24</td>
                                                        <td>แพ็ก</td>
                                                        <td>10 แพ็ก</td>
                                                        <td><span class="badge badge-soft-success">ปกติ</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>น้ำปลา</td>
                                                        <td>เครื่องปรุง</td>
                                                        <td class="text-end">9</td>
                                                        <td>ขวด</td>
                                                        <td>8 ขวด</td>
                                                        <td><span class="badge badge-soft-warning">ใกล้หมด</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="history-tab" role="tabpanel">
                                        <div class="table-responsive table-centered">
                                            <table class="table text-nowrap mb-0">
                                                <thead class="bg-light bg-opacity-50">
                                                    <tr>
                                                        <th>วันที่</th>
                                                        <th>รายการ</th>
                                                        <th class="text-end">จำนวน</th>
                                                        <th>หน่วย</th>
                                                        <th>ผู้ทำรายการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/03/2025</td>
                                                        <td>เพิ่ม ซอสหอยนางรม</td>
                                                        <td class="text-end">12</td>
                                                        <td>ขวด</td>
                                                        <td>ผู้จัดการครัว</td>
                                                    </tr>
                                                    <tr>
                                                        <td>09/03/2025</td>
                                                        <td>เพิ่ม อกไก่</td>
                                                        <td class="text-end">5</td>
                                                        <td>กิโลกรัม</td>
                                                        <td>Chef A</td>
                                                    </tr>
                                                    <tr>
                                                        <td>08/03/2025</td>
                                                        <td>เพิ่ม ผักโขม</td>
                                                        <td class="text-end">10</td>
                                                        <td>แพ็ก</td>
                                                        <td>Chef B</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="order-tab" role="tabpanel">
                                        <div class="table-responsive table-centered">
                                            <table class="table text-nowrap mb-0">
                                                <thead class="bg-light bg-opacity-50">
                                                    <tr>
                                                        <th>วันที่</th>
                                                        <th>หมายเลขออเดอร์</th>
                                                        <th>รายการที่ใช้</th>
                                                        <th class="text-end">จำนวน</th>
                                                        <th>หน่วย</th>
                                                        <th>ผลกระทบสต็อก</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/03/2025</td>
                                                        <td>#ODR-1045</td>
                                                        <td>เนื้อหมูสันใน</td>
                                                        <td class="text-end">0.8</td>
                                                        <td>กิโลกรัม</td>
                                                        <td class="text-danger">-0.8 กก.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>09/03/2025</td>
                                                        <td>#ODR-1038</td>
                                                        <td>ผักโขม</td>
                                                        <td class="text-end">2</td>
                                                        <td>แพ็ก</td>
                                                        <td class="text-danger">-2 แพ็ก</td>
                                                    </tr>
                                                    <tr>
                                                        <td>08/03/2025</td>
                                                        <td>#ODR-1032</td>
                                                        <td>แซลมอน</td>
                                                        <td class="text-end">1.5</td>
                                                        <td>กิโลกรัม</td>
                                                        <td class="text-danger">-1.5 กก.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container Fluid -->

            <?php include "partials/footer.php" ?>

        </div>
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->

    </div>
    <!-- END Wrapper -->

    <!-- Modal: Add Stock -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มสต็อกวัตถุดิบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ชื่อวัตถุดิบ</label>
                            <input type="text" class="form-control" placeholder="เช่น เนื้อหมู, อกไก่">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">หมวดหมู่วัตถุดิบ</label>
                            <select class="form-select">
                                <option selected>เลือกหมวดหมู่</option>
                                <option>เนื้อสัตว์</option>
                                <option>ผัก</option>
                                <option>เครื่องปรุง</option>
                                <option>ของแห้ง</option>
                            </select>
                            <small class="text-muted d-block mt-2">หากไม่มีหมวดหมู่ที่ต้องการ กรอกเพิ่มด้านล่าง</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">เพิ่มหมวดหมู่ใหม่ (ถ้ามี)</label>
                            <input type="text" class="form-control" placeholder="พิมพ์ชื่อหมวดหมู่ใหม่">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">จำนวนที่เพิ่ม</label>
                            <input type="number" class="form-control" min="0" step="0.1" placeholder="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">หน่วยปริมาณ</label>
                            <select class="form-select">
                                <option>กิโลกรัม</option>
                                <option>ชิ้น</option>
                                <option>แพ็ก</option>
                                <option>ลิตร</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">กำหนดขั้นต่ำของสต็อก</label>
                            <div class="input-group">
                                <input type="number" class="form-control" min="0" step="0.1" placeholder="เช่น 5 หรือ 20%">
                                <span class="input-group-text">หน่วย/เปอร์เซ็นต์</span>
                            </div>
                            <small class="text-muted">ใช้ตัวเลขเดี่ยวหรือระบุเป็นเปอร์เซ็นต์ของสต็อกทั้งหมด</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">บันทึกหมายเหตุ</label>
                            <textarea class="form-control" rows="2" placeholder="รายละเอียดเพิ่ม เช่น ผู้จัดซื้อ, เลขที่ใบสั่งของ"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'partials/vendor-scripts.php' ?>
</body>

</html>
