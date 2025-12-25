<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Table Management";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Table Management";
        
        $tables = [
            ['id' => 1, 'number' => 1, 'seats' => 4, 'zone' => 'ชั้น 1'],
            ['id' => 2, 'number' => 2, 'seats' => 4, 'zone' => 'ชั้น 1'],
            ['id' => 3, 'number' => 3, 'seats' => 2, 'zone' => 'ชั้น 1'],
            ['id' => 4, 'number' => 4, 'seats' => 6, 'zone' => 'ชั้น 1'],
            ['id' => 5, 'number' => 5, 'seats' => 4, 'zone' => 'ชั้น 2'],
            ['id' => 6, 'number' => 6, 'seats' => 4, 'zone' => 'ชั้น 2'],
            ['id' => 7, 'number' => 7, 'seats' => 8, 'zone' => 'ชั้น 2'],
            ['id' => 8, 'number' => 8, 'seats' => 2, 'zone' => 'ชั้น 2'],
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
                                    <h4 class="mb-1">จัดการโต๊ะ</h4>
                                    <p class="text-muted mb-0">เพิ่ม แก้ไข และจัดการโต๊ะทั้งหมด</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTableModal">
                                        <i class="bx bx-plus me-1"></i>เพิ่มโต๊ะ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">รายการโต๊ะทั้งหมด (<?php echo count($tables); ?>)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>หมายเลขโต๊ะ</th>
                                                <th>จำนวนที่นั่ง</th>
                                                <th>โซน</th>
                                                <th>QR Code</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tables as $table): ?>
                                                <tr>
                                                    <td class="fw-bold">โต๊ะ <?php echo $table['number']; ?></td>
                                                    <td><?php echo $table['seats']; ?> ที่นั่ง</td>
                                                    <td><span class="badge badge-soft-primary"><?php echo $table['zone']; ?></span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-soft-info" onclick="viewQR(<?php echo $table['number']; ?>)">
                                                            <i class="bx bx-qr"></i> ดู QR
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <button class="btn btn-sm btn-soft-secondary" onclick="editTable(<?php echo $table['id']; ?>)">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-soft-danger" onclick="deleteTable(<?php echo $table['id']; ?>)">
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

    <!-- Add Table Modal -->
    <div class="modal fade" id="addTableModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มโต๊ะใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTableForm">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">หมายเลขโต๊ะ <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tableNumber" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">จำนวนที่นั่ง <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tableSeats" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">โซน</label>
                                <select class="form-select" id="tableZone">
                                    <option value="ชั้น 1">ชั้น 1</option>
                                    <option value="ชั้น 2">ชั้น 2</option>
                                    <option value="ลานนอก">ลานนอก</option>
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
        document.getElementById('addTableForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('เพิ่มโต๊ะสำเร็จ');
            bootstrap.Modal.getInstance(document.getElementById('addTableModal')).hide();
            this.reset();
        });
        
        function editTable(id) {
            alert('แก้ไขโต๊ะ ID: ' + id);
        }
        
        function deleteTable(id) {
            if (confirm('ต้องการลบโต๊ะนี้ใช่หรือไม่?')) {
                alert('ลบโต๊ะ ID: ' + id + ' สำเร็จ');
            }
        }
        
        function viewQR(number) {
            window.open('staff-qr-code.php?table=' + number, '_blank');
        }
    </script>
</body>
</html>
