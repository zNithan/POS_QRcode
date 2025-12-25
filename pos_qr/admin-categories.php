<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Category Management";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Category Management";
        
        $categories = [
            ['id' => 1, 'name' => 'เมนูหลัก', 'count' => 24, 'color' => 'primary'],
            ['id' => 2, 'name' => 'เครื่องดื่ม', 'count' => 12, 'color' => 'info'],
            ['id' => 3, 'name' => 'ของหวาน', 'count' => 8, 'color' => 'warning'],
            ['id' => 4, 'name' => 'เมนูพิเศษ', 'count' => 4, 'color' => 'danger'],
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
                                    <h4 class="mb-1">จัดการหมวดหมู่อาหาร</h4>
                                    <p class="text-muted mb-0">เพิ่ม แก้ไข และจัดการหมวดหมู่เมนู</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        <i class="bx bx-plus me-1"></i>เพิ่มหมวดหมู่
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                            <?php foreach ($categories as $cat): ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <iconify-icon icon="solar:tag-bold-duotone" class="fs-48 text-<?php echo $cat['color']; ?> mb-3"></iconify-icon>
                                            <h5 class="mb-1"><?php echo $cat['name']; ?></h5>
                                            <p class="text-muted mb-3"><?php echo $cat['count']; ?> เมนู</p>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button class="btn btn-sm btn-soft-secondary" onclick="editCategory(<?php echo $cat['id']; ?>)">
                                                    <i class="bx bx-edit"></i> แก้ไข
                                                </button>
                                                <button class="btn btn-sm btn-soft-danger" onclick="deleteCategory(<?php echo $cat['id']; ?>)">
                                                    <i class="bx bx-trash"></i> ลบ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php include "partials/footer.php" ?>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มหมวดหมู่ใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCategoryForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="categoryName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">สีประจำหมวดหมู่</label>
                            <select class="form-select" id="categoryColor">
                                <option value="primary">น้ำเงิน</option>
                                <option value="success">เขียว</option>
                                <option value="warning">เหลือง</option>
                                <option value="danger">แดง</option>
                                <option value="info">ฟ้า</option>
                                <option value="purple">ม่วง</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'partials/vendor-scripts.php' ?>
    <script>
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('เพิ่มหมวดหมู่สำเร็จ');
            bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
            this.reset();
        });
        
        function editCategory(id) {
            alert('แก้ไขหมวดหมู่ ID: ' + id);
        }
        
        function deleteCategory(id) {
            if (confirm('ต้องการลบหมวดหมู่นี้ใช่หรือไม่?')) {
                alert('ลบหมวดหมู่ ID: ' + id + ' สำเร็จ');
            }
        }
    </script>
</body>
</html>
