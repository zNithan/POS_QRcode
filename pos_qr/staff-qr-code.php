<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "QR Code";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        @media (max-width: 767px) {
            .container-xxl { padding-left: 0.5rem; padding-right: 0.5rem; }
            .card-body { padding: 0.75rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
            .ms-auto { margin-left: 0 !important; margin-top: 0.5rem; }
            .d-flex.flex-wrap { flex-direction: column; align-items: flex-start !important; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php 
        $subTitle = "QR Code";
        
        $tables = [
            ['id' => 1, 'name' => 'โต๊ะ 1'],
            ['id' => 2, 'name' => 'โต๊ะ 2'],
            ['id' => 3, 'name' => 'โต๊ะ 3'],
            ['id' => 4, 'name' => 'โต๊ะ 4'],
            ['id' => 5, 'name' => 'โต๊ะ 5'],
            ['id' => 6, 'name' => 'โต๊ะ 6'],
            ['id' => 7, 'name' => 'โต๊ะ 7'],
            ['id' => 8, 'name' => 'โต๊ะ 8'],
        ];

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
                                    <h4 class="mb-1">QR Code โต๊ะ</h4>
                                    <p class="text-muted mb-0">สร้างและพิมพ์ QR Code สำหรับลูกค้าสั่งอาหารเอง</p>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-primary" onclick="window.print()"><i class="bx bx-printer me-1"></i>พิมพ์ทั้งหมด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
                            <?php foreach ($tables as $table): 
                                $qrUrl = "https://restaurant.com/order?table=" . $table['id'];
                                $qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrUrl);
                            ?>
                                <div class="col">
                                    <div class="card h-100 text-center">
                                        <div class="card-body">
                                            <h5 class="mb-3"><?php echo $table['name']; ?></h5>
                                            <div class="mb-3">
                                                <img src="<?php echo $qrImageUrl; ?>" alt="QR Code <?php echo $table['name']; ?>" class="img-fluid" style="max-width: 200px;">
                                            </div>
                                            <p class="text-muted small mb-2">สแกนเพื่อสั่งอาหาร</p>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <button class="btn btn-sm btn-primary" onclick="printQR(<?php echo $table['id']; ?>)">
                                                    <i class="bx bx-printer"></i> พิมพ์
                                                </button>
                                                <button class="btn btn-sm btn-soft-secondary" onclick="downloadQR(<?php echo $table['id']; ?>, '<?php echo $qrImageUrl; ?>')">
                                                    <i class="bx bx-download"></i> ดาวน์โหลด
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

    <?php include 'partials/vendor-scripts.php' ?>
    <script>
        function printQR(tableId) {
            var printWindow = window.open('', '_blank');
            var qrCard = document.querySelector('[data-table="' + tableId + '"]');
            printWindow.document.write('<html><head><title>QR Code - โต๊ะ ' + tableId + '</title>');
            printWindow.document.write('<style>body{text-align:center;font-family:Arial;padding:20px;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>โต๊ะ ' + tableId + '</h2>');
            printWindow.document.write('<img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https://restaurant.com/order?table=' + tableId + '" style="width:300px;">');
            printWindow.document.write('<p>สแกนเพื่อสั่งอาหาร</p>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function downloadQR(tableId, imageUrl) {
            var link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'QR-Table-' + tableId + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
