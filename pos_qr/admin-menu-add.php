<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Add Menu";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Add Menu";
        
        $categories = ['เมนูหลัก', 'เครื่องดื่ม', 'ของหวาน', 'เมนูพิเศษ'];
        $isEdit = isset($_GET['id']);
        
        include 'partials/topbar.php'; ?>
        <?php include 'partials/main-nav.php'; ?>

        <div class="page-content">
            <div class="container-xxl">

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                                <a href="admin-menu-list.php" class="btn btn-soft-secondary"><i class="bx bx-arrow-back"></i></a>
                                <div>
                                    <h4 class="mb-1"><?php echo $isEdit ? 'แก้ไข' : 'เพิ่ม'; ?>เมนูอาหาร</h4>
                                    <p class="text-muted mb-0">กรอกข้อมูลเมนูและอัปโหลดรูปภาพ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <form id="menuForm">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">ข้อมูลเมนู</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อเมนู <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="menuName" placeholder="เช่น ข้าวผัดกุ้ง" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">หมวดหมู่ <span class="text-danger">*</span></label>
                                            <select class="form-select" id="category" required>
                                                <option value="">เลือกหมวดหมู่</option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ราคา (บาท) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="price" placeholder="0" min="0" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">สถานะ</label>
                                            <select class="form-select" id="status">
                                                <option value="available" selected>พร้อมขาย</option>
                                                <option value="unavailable">หมด</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">รายละเอียด / ส่วนผสม</label>
                                            <textarea class="form-control" id="description" rows="4" 
                                                placeholder="อธิบายรายละเอียดเมนู ส่วนผสม หรือวิธีการทำ..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">อัปโหลดรูปภาพ</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">รูปเมนู (300x300px)</label>
                                            <input type="file" class="form-control" id="thumbnailImage" accept="image/jpeg,image/png">
                                            <small class="text-muted">JPG, PNG | สูงสุด 500KB</small>
                                            <div class="mt-2" id="thumbnailPreview"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">รูปรายละเอียด (600x600px)</label>
                                            <input type="file" class="form-control" id="detailImage" accept="image/jpeg,image/png">
                                            <small class="text-muted">JPG, PNG | สูงสุด 500KB</small>
                                            <div class="mt-2" id="detailPreview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>บันทึกเมนู
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('menuForm').reset()">
                                    <i class="bx bx-refresh me-1"></i>ล้างข้อมูล
                                </button>
                                <a href="admin-menu-list.php" class="btn btn-soft-secondary">ยกเลิก</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-4">
                        <div class="card sticky-top" style="top: 80px;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">คำแนะนำ</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6><i class="bx bx-image text-primary me-1"></i>ข้อกำหนดรูปภาพ</h6>
                                    <ul class="text-muted small mb-0">
                                        <li>รูปเมนู: 300x300px</li>
                                        <li>รูปรายละเอียด: 600x600px</li>
                                        <li>ไฟล์: JPG, PNG</li>
                                        <li>ขนาดสูงสุด: 500KB</li>
                                    </ul>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="bx bx-info-circle text-info me-1"></i>การตั้งราคา</h6>
                                    <ul class="text-muted small mb-0">
                                        <li>ตั้งราคาให้เหมาะสมกับต้นทุน</li>
                                        <li>เพิ่มภาษี 7% จะคำนวณอัตโนมัติ</li>
                                    </ul>
                                </div>
                                <div>
                                    <h6><i class="bx bx-book text-success me-1"></i>รายละเอียดเมนู</h6>
                                    <ul class="text-muted small mb-0">
                                        <li>ระบุส่วนผสมหลัก</li>
                                        <li>แจ้งข้อมูลอาหารพิเศษ</li>
                                        <li>ใส่คำเตือนสำหรับผู้แพ้อาหาร</li>
                                    </ul>
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
        function previewImage(input, previewId) {
            var preview = document.getElementById(previewId);
            
            if (input.files && input.files[0]) {
                var file = input.files[0];
                
                // Validate file size (500KB)
                if (file.size > 500 * 1024) {
                    alert('ขนาดไฟล์ใหญ่เกินไป (สูงสุด 500KB)');
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    alert('รองรับเฉพาะไฟล์ JPG และ PNG เท่านั้น');
                    input.value = '';
                    return;
                }
                
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px;">';
                };
                reader.readAsDataURL(file);
            }
        }
        
        document.getElementById('thumbnailImage').addEventListener('change', function() {
            previewImage(this, 'thumbnailPreview');
        });
        
        document.getElementById('detailImage').addEventListener('change', function() {
            previewImage(this, 'detailPreview');
        });
        
        document.getElementById('menuForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var menuName = document.getElementById('menuName').value;
            var category = document.getElementById('category').value;
            var price = document.getElementById('price').value;
            
            if (!menuName || !category || !price) {
                alert('กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน');
                return;
            }
            
            alert('บันทึกเมนูสำเร็จ');
            window.location.href = 'admin-menu-list.php';
        });
    </script>
</body>
</html>
