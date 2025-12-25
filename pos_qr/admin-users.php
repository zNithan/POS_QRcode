<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "User Management";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "User Management";
        
        // Mock data
        $users = [
            ['id' => 1, 'username' => 'admin01', 'email' => 'admin01@restaurant.com', 'role' => 'Administrator', 'status' => 'active', 'created' => '2024-01-15'],
            ['id' => 2, 'username' => 'admin02', 'email' => 'admin02@restaurant.com', 'role' => 'Administrator', 'status' => 'active', 'created' => '2024-02-10'],
            ['id' => 3, 'username' => 'staff01', 'email' => 'staff01@restaurant.com', 'role' => 'Staff', 'status' => 'active', 'created' => '2024-03-05'],
            ['id' => 4, 'username' => 'staff02', 'email' => 'staff02@restaurant.com', 'role' => 'Staff', 'status' => 'active', 'created' => '2024-03-12'],
            ['id' => 5, 'username' => 'staff03', 'email' => 'staff03@restaurant.com', 'role' => 'Staff', 'status' => 'inactive', 'created' => '2024-04-01'],
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
                                    <h4 class="mb-1">จัดการผู้ใช้งานระบบ</h4>
                                    <p class="text-muted mb-0">เพิ่ม แก้ไข และกำหนดสิทธิ์ผู้ใช้งาน</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        <i class="bx bx-plus me-1"></i>เพิ่มผู้ใช้งาน
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">รายชื่อผู้ใช้งาน</h5>
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm" style="width: auto;">
                                        <option selected>ทั้งหมด</option>
                                        <option>Administrator</option>
                                        <option>Staff</option>
                                    </select>
                                    <select class="form-select form-select-sm" style="width: auto;">
                                        <option selected>สถานะทั้งหมด</option>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>ID</th>
                                                <th>ชื่อผู้ใช้งาน</th>
                                                <th>อีเมล</th>
                                                <th>สิทธิ์</th>
                                                <th>สถานะ</th>
                                                <th>วันที่สร้าง</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td>#<?php echo str_pad($user['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                                    <td class="fw-semibold"><?php echo $user['username']; ?></td>
                                                    <td><?php echo $user['email']; ?></td>
                                                    <td>
                                                        <span class="badge badge-soft-<?php echo $user['role'] === 'Administrator' ? 'danger' : 'info'; ?>">
                                                            <?php echo $user['role']; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-soft-<?php echo $user['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                            <?php echo $user['status'] === 'active' ? 'ใช้งาน' : 'ปิดใช้งาน'; ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo date('d/m/Y', strtotime($user['created'])); ?></td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <button class="btn btn-sm btn-soft-secondary" onclick="editUser(<?php echo $user['id']; ?>)">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-soft-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มผู้ใช้งานใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" required>
                                <small class="text-muted">ใช้สำหรับเข้าสู่ระบบ</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" required minlength="6">
                                <small class="text-muted">อย่างน้อย 6 ตัวอักษร</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="confirmPassword" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">สิทธิ์การใช้งาน <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" required>
                                    <option value="">เลือกสิทธิ์</option>
                                    <option value="Administrator">Administrator - จัดการระบบเต็มรูปแบบ</option>
                                    <option value="Staff">Staff - พนักงานหน้าร้าน</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">สถานะ</label>
                                <select class="form-select" id="status">
                                    <option value="active" selected>ใช้งาน</option>
                                    <option value="inactive">ปิดใช้งาน</option>
                                </select>
                            </div>
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
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง');
                return;
            }
            
            if (password.length < 6) {
                alert('รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร');
                return;
            }
            
            alert('เพิ่มผู้ใช้งานสำเร็จ');
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            this.reset();
        });
        
        function editUser(id) {
            alert('แก้ไขผู้ใช้งาน ID: ' + id);
        }
        
        function deleteUser(id) {
            if (confirm('ต้องการลบผู้ใช้งานนี้ใช่หรือไม่?')) {
                alert('ลบผู้ใช้งาน ID: ' + id + ' สำเร็จ');
            }
        }
    </script>
</body>
</html>
