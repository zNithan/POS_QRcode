<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Member Management";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "Member Management";
        
        $members = [
            ['id' => 1, 'name' => 'คุณอารีย์ สมบูรณ์', 'phone' => '081-234-5678', 'email' => 'aree@email.com', 'tier' => 'Gold', 'points' => 250, 'joined' => '2024-01-15'],
            ['id' => 2, 'name' => 'คุณภาสกร ทองดี', 'phone' => '089-765-4321', 'email' => 'passakorn@email.com', 'tier' => 'Silver', 'points' => 150, 'joined' => '2024-02-20'],
            ['id' => 3, 'name' => 'คุณญาดา รุ่งเรือง', 'phone' => '062-111-2222', 'email' => 'yada@email.com', 'tier' => 'Platinum', 'points' => 580, 'joined' => '2023-11-10'],
            ['id' => 4, 'name' => 'คุณชัยวัฒน์ ศรีสุข', 'phone' => '091-888-9999', 'email' => 'chaiwat@email.com', 'tier' => 'Gold', 'points' => 320, 'joined' => '2024-03-05'],
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
                                    <h4 class="mb-1">จัดการสมาชิก</h4>
                                    <p class="text-muted mb-0">ดู แก้ไข และจัดการข้อมูลสมาชิก</p>
                                </div>
                                <div class="ms-auto d-flex gap-2">
                                    <div class="search-bar">
                                        <span><i class="bx bx-search-alt"></i></span>
                                        <input type="search" class="form-control" placeholder="ค้นหาสมาชิก...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">สมาชิกทั้งหมด (<?php echo count($members); ?>)</h5>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option selected>ทุกระดับ</option>
                                    <option>Platinum</option>
                                    <option>Gold</option>
                                    <option>Silver</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-centered">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>ID</th>
                                                <th>ชื่อ</th>
                                                <th>เบอร์โทร</th>
                                                <th>อีเมล</th>
                                                <th>ระดับ</th>
                                                <th class="text-end">แต้มสะสม</th>
                                                <th>วันที่สมัคร</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($members as $member): ?>
                                                <tr>
                                                    <td>#<?php echo str_pad($member['id'], 4, '0', STR_PAD_LEFT); ?></td>
                                                    <td class="fw-semibold"><?php echo $member['name']; ?></td>
                                                    <td><?php echo $member['phone']; ?></td>
                                                    <td><?php echo $member['email']; ?></td>
                                                    <td>
                                                        <?php 
                                                        $tierColors = ['Platinum' => 'purple', 'Gold' => 'warning', 'Silver' => 'secondary'];
                                                        $color = $tierColors[$member['tier']];
                                                        ?>
                                                        <span class="badge badge-soft-<?php echo $color; ?>"><?php echo $member['tier']; ?></span>
                                                    </td>
                                                    <td class="text-end fw-bold text-primary"><?php echo number_format($member['points']); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($member['joined'])); ?></td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <button class="btn btn-sm btn-soft-info" onclick="viewMember(<?php echo $member['id']; ?>)">
                                                                <i class="bx bx-show"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-soft-secondary" onclick="editMember(<?php echo $member['id']; ?>)">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-soft-danger" onclick="deleteMember(<?php echo $member['id']; ?>)">
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

    <?php include 'partials/vendor-scripts.php' ?>
    <script>
        function viewMember(id) {
            alert('ดูรายละเอียดสมาชิก ID: ' + id);
        }
        
        function editMember(id) {
            alert('แก้ไขข้อมูลสมาชิก ID: ' + id);
        }
        
        function deleteMember(id) {
            if (confirm('ต้องการลบสมาชิกนี้ใช่หรือไม่?')) {
                alert('ลบสมาชิก ID: ' + id + ' สำเร็จ');
            }
        }
    </script>
</body>
</html>
