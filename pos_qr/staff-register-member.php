<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Register Member";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .form-label { font-size: 0.875rem; }
            .form-control { font-size: 0.875rem; padding: 0.375rem 0.75rem; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Register Member";
        
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
                                    <h4 class="mb-1">ลงทะเบียนสมาชิก</h4>
                                    <p class="text-muted mb-0">บันทึกข้อมูลสมาชิกใหม่และเชื่อมกับออเดอร์</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">ข้อมูลสมาชิก</h5>
                            </div>
                            <div class="card-body">
                                <form id="memberForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName" placeholder="ชื่อจริง" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName" placeholder="นามสกุล" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone" placeholder="0812345678" required pattern="[0-9]{10}">
                                            <small class="text-muted">ใช้สำหรับค้นหาสมาชิกและสะสมแต้ม</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" id="email" placeholder="example@email.com">
                                            <small class="text-muted">ไม่บังคับ</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">วันเกิด</label>
                                            <input type="date" class="form-control" id="birthday">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">เพศ</label>
                                            <select class="form-select" id="gender">
                                                <option value="">ไม่ระบุ</option>
                                                <option value="male">ชาย</option>
                                                <option value="female">หญิง</option>
                                                <option value="other">อื่นๆ</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">ที่อยู่ (ไม่บังคับ)</label>
                                            <textarea class="form-control" id="address" rows="3" placeholder="บ้านเลขที่ ถนน ตำบล อำเภอ จังหวัด"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="linkToOrder">
                                                <label class="form-check-label" for="linkToOrder">
                                                    เชื่อมโยงกับออเดอร์ปัจจุบัน (ถ้ามี)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12" id="orderLinkSection" style="display: none;">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <label class="form-label">เลือกโต๊ะที่ต้องการเชื่อมโยง</label>
                                                    <select class="form-select" id="tableSelect">
                                                        <option value="">เลือกโต๊ะ</option>
                                                        <option value="1">โต๊ะ 1</option>
                                                        <option value="2">โต๊ะ 2</option>
                                                        <option value="3">โต๊ะ 3</option>
                                                        <option value="4">โต๊ะ 4</option>
                                                        <option value="5">โต๊ะ 5</option>
                                                        <option value="6">โต๊ะ 6</option>
                                                        <option value="7">โต๊ะ 7</option>
                                                        <option value="8">โต๊ะ 8</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save me-1"></i>บันทึกสมาชิก
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('memberForm').reset()">
                                            <i class="bx bx-refresh me-1"></i>ล้างข้อมูล
                                        </button>
                                        <a href="staff-dashboard.php" class="btn btn-soft-secondary">
                                            ยกเลิก
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">สิทธิประโยชน์สมาชิก</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <iconify-icon icon="solar:star-bold-duotone" class="fs-32 text-warning"></iconify-icon>
                                            <h6 class="mt-2">สะสมแต้ม</h6>
                                            <p class="text-muted small mb-0">ทุก 100 บาท = 1 แต้ม</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <iconify-icon icon="solar:gift-bold-duotone" class="fs-32 text-success"></iconify-icon>
                                            <h6 class="mt-2">ส่วนลดพิเศษ</h6>
                                            <p class="text-muted small mb-0">รับส่วนลดวันเกิด</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <iconify-icon icon="solar:bell-bing-bold-duotone" class="fs-32 text-info"></iconify-icon>
                                            <h6 class="mt-2">โปรโมชั่น</h6>
                                            <p class="text-muted small mb-0">แจ้งโปรโมชั่นใหม่ก่อนใคร</p>
                                        </div>
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-48 text-success mb-3"></iconify-icon>
                    <h4 class="mb-2">ลงทะเบียนสำเร็จ!</h4>
                    <p class="text-muted mb-3">บันทึกข้อมูลสมาชิกเรียบร้อยแล้ว</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="staff-dashboard.php" class="btn btn-primary">กลับหน้าหลัก</a>
                        <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">ลงทะเบียนต่อ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'partials/vendor-scripts.php' ?>
    <script>
        (function() {
            var linkCheckbox = document.getElementById('linkToOrder');
            var orderSection = document.getElementById('orderLinkSection');

            linkCheckbox.addEventListener('change', function() {
                orderSection.style.display = this.checked ? 'block' : 'none';
            });

            document.getElementById('memberForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                var firstName = document.getElementById('firstName').value;
                var lastName = document.getElementById('lastName').value;
                var phone = document.getElementById('phone').value;

                if (!firstName || !lastName || !phone) {
                    alert('กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน');
                    return;
                }

                if (!/^[0-9]{10}$/.test(phone)) {
                    alert('กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง (10 หลัก)');
                    return;
                }

                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                
                this.reset();
            });
        })();
    </script>
</body>
</html>
