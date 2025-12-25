<?php include 'partials/main.php' ?>

<head>
    <?php
    $subTitle = "Kitchen Order List";
    include 'partials/title-meta.php';
    include 'partials/head-css.php';

    $orders = [
        [
            'id'         => 'K-1024',
            'table'      => 'A1',
            'order_no'   => 'K-1024',
            'placed_at'  => '2025-12-24 11:58',
            'status'     => 'pending',
            'priority'   => 'high',
            'items'      => [
                ['name' => 'ต้มยำกุ้ง', 'qty' => 2],
                ['name' => 'ไข่เจียวหมูสับ', 'qty' => 1],
                ['name' => 'ข้าวสวย', 'qty' => 3],
            ],
            'note'       => 'ไม่ใส่ผักชี, เพิ่มความเผ็ด',
            'channel'    => 'หน้าร้าน',
        ],
        [
            'id'         => 'K-1025',
            'table'      => 'B5',
            'order_no'   => 'K-1025',
            'placed_at'  => '2025-12-24 12:04',
            'status'     => 'in_progress',
            'started_at' => '2025-12-24 12:05',
            'priority'   => 'normal',
            'items'      => [
                ['name' => 'ส้มตำไทย', 'qty' => 1],
                ['name' => 'ไก่ย่างหนังกรอบ', 'qty' => 1],
                ['name' => 'ข้าวเหนียว', 'qty' => 2],
            ],
            'note'       => 'แยกพริกป่นใส่ถ้วย',
            'channel'    => 'พนักงานหน้าร้าน',
        ],
        [
            'id'         => 'K-1026',
            'table'      => 'C2',
            'order_no'   => 'K-1026',
            'placed_at'  => '2025-12-24 12:10',
            'status'     => 'pending',
            'priority'   => 'high',
            'items'      => [
                ['name' => 'แกงเขียวหวานไก่', 'qty' => 1],
                ['name' => 'ปอเปี๊ยะทอด', 'qty' => 2],
            ],
            'note'       => 'เสิร์ฟพร้อมผักเคียง',
            'channel'    => 'ออเดอร์เดลิเวอรี',
        ],
        [
            'id'         => 'K-1027',
            'table'      => 'D3',
            'order_no'   => 'K-1027',
            'placed_at'  => '2025-12-24 11:45',
            'status'     => 'done',
            'started_at' => '2025-12-24 11:47',
            'priority'   => 'normal',
            'items'      => [
                ['name' => 'กระเพราเนื้อไข่ดาว', 'qty' => 1],
                ['name' => 'น้ำเปล่า', 'qty' => 1],
            ],
            'note'       => '',
            'channel'    => 'หน้าร้าน',
        ],
    ];

    $statusStyles = [
        'pending'     => ['label' => 'รับออเดอร์', 'class' => 'bg-warning text-dark', 'border' => 'warning'],
        'in_progress' => ['label' => 'กำลังทำ', 'class' => 'bg-info text-light', 'border' => 'info'],
        'done'        => ['label' => 'ทำเสร็จแล้ว', 'class' => 'bg-success text-light', 'border' => 'success'],
    ];

    $activeOrders = array_values(array_filter($orders, function ($order) {
        return $order['status'] !== 'done';
    }));
    ?>

    <style>
        .kitchen-card {
            min-height: 360px;
            background: #0f172a0d;
        }

        .kitchen-line+.kitchen-line {
            border-top: 1px dashed var(--ct-border-color, #e5e7eb);
        }

        .kitchen-note {
            background: rgba(255, 193, 7, 0.12);
            border: 1px dashed rgba(255, 193, 7, 0.6);
        }

        .kitchen-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            display: inline-block;
        }

        .kitchen-actions {
            display: grid;
            gap: 0.5rem;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .kitchen-actions .btn {
            padding: 0.9rem 1rem;
            font-size: 1rem;
            font-weight: 700;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 12px;
            }

            .print-slip {
                width: 320px;
                font-size: 14px;
                color: #000;
            }

            .print-slip h5 {
                margin: 0 0 8px;
                font-size: 16px;
            }

            .print-slip ul {
                padding-left: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- START Wrapper -->
    <div class="wrapper">

        <?php
        $subTitle = "Kitchen Order List";
        include 'partials/topbar.php';
        ?>
        <?php include 'partials/main-nav.php'; ?>

        <div>
            <div class="page-content">
                <div class="container-xxl">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h4 class="mb-1">Kitchen Display / KDS</h4>
                            <p class="text-muted mb-0">แสดงเฉพาะออเดอร์ที่ยังไม่เสร็จ อัปเดตอัตโนมัติ</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success fw-semibold">Live</span>
                            <div class="text-muted small">อัปเดตล่าสุด <span id="last-refresh" class="fw-semibold">--:--</span></div>
                            <button class="btn btn-soft-info btn-sm" id="refresh-btn">
                                <iconify-icon icon="solar:refresh-broken" class="align-middle me-1"></iconify-icon>
                                รีเฟรช
                            </button>
                        </div>
                    </div>

                    <div class="row g-3" id="kitchen-board">
                        <?php foreach ($activeOrders as $order):
                            $status = $statusStyles[$order['status']] ?? $statusStyles['pending'];
                            $startedAt = $order['started_at'] ?? null;
                        ?>
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card kitchen-card border-2 border-<?php echo $status['border']; ?> h-100"
                                    data-order-id="<?php echo htmlspecialchars($order['id']); ?>"
                                    data-status="<?php echo htmlspecialchars($order['status']); ?>"
                                    data-table="<?php echo htmlspecialchars($order['table']); ?>"
                                    data-order-code="<?php echo htmlspecialchars($order['order_no']); ?>"
                                    data-note="<?php echo htmlspecialchars($order['note']); ?>"
                                    data-placed-at="<?php echo htmlspecialchars($order['placed_at']); ?>"
                                    data-started-at="<?php echo htmlspecialchars($startedAt ?? ''); ?>">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="text-muted text-uppercase fs-12">โต๊ะ</div>
                                                <div class="fs-20 fw-semibold"><?php echo htmlspecialchars($order['table']); ?></div>
                                                <div class="text-muted fs-12">เข้า <?php echo date('H:i', strtotime($order['placed_at'])); ?></div>
                                            </div>
                                            <div class="text-end">
                                                <div class="badge <?php echo $status['class']; ?> status-badge"><?php echo $status['label']; ?></div>
                                                <div class="fw-semibold mt-1">#<?php echo htmlspecialchars($order['order_no']); ?></div>
                                            </div>
                                        </div>

                                        <div class="border rounded mt-3 p-2 bg-light-subtle">
                                            <div class="d-flex justify-content-between text-muted fs-12">
                                                <span>รายการ</span>
                                                <span>จำนวน</span>
                                            </div>
                                            <?php foreach ($order['items'] as $item): ?>
                                                <div class="d-flex justify-content-between py-1 kitchen-line">
                                                    <span class="fw-semibold"><?php echo htmlspecialchars($item['name']); ?></span>
                                                    <span class="text-muted">x<?php echo (int) $item['qty']; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <?php if (!empty($order['note'])): ?>
                                            <div class="alert alert-warning py-2 px-3 mt-3 kitchen-note">
                                                <div class="fw-semibold">หมายเหตุ</div>
                                                <div><?php echo htmlspecialchars($order['note']); ?></div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-auto pt-3 kitchen-actions">
                                            <button class="btn btn-primary accept-btn" <?php echo $order['status'] !== 'pending' ? 'disabled' : ''; ?>>รับออเดอร์</button>
                                            <button class="btn btn-success done-btn" <?php echo $order['status'] === 'done' ? 'disabled' : ''; ?>>ทำเสร็จแล้ว</button>
                                            <button class="btn btn-outline-secondary print-btn">พิมพ์ใบออเดอร์</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <script type="application/json" id="kitchen-order-data">
                        <?php echo json_encode($activeOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>
                    </script>

                </div>

                <?php include 'partials/footer.php'; ?>
            </div>
        </div>
    </div>
    <!-- END Wrapper -->

    <?php include 'partials/vendor-scripts.php'; ?>
    <div id="print-area" class="d-none"></div>

    <script>
        (function() {
            const statusMap = {
                pending: {
                    label: 'รับออเดอร์',
                    className: 'bg-warning text-dark',
                    borderClass: 'border-warning'
                },
                in_progress: {
                    label: 'กำลังทำ',
                    className: 'bg-info text-light',
                    borderClass: 'border-info'
                },
                done: {
                    label: 'ทำเสร็จแล้ว',
                    className: 'bg-success text-light',
                    borderClass: 'border-success'
                },
            };

            const statusBorders = ['border-warning', 'border-info', 'border-success'];
            const orderDataEl = document.getElementById('kitchen-order-data');
            const orderData = orderDataEl ? JSON.parse(orderDataEl.textContent) : [];
            const orderMap = Object.fromEntries(orderData.map((o) => [o.id, o]));
            const printArea = document.getElementById('print-area');

            const formatTime = (value) => {
                const date = value instanceof Date ? value : new Date(value);
                if (Number.isNaN(date.getTime())) return '--:--';
                return date.toLocaleTimeString('th-TH', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            };

            const updateStatus = (card, statusKey) => {
                const status = statusMap[statusKey] || statusMap.pending;
                const badge = card.querySelector('.status-badge');
                badge.className = `badge status-badge ${status.className}`;
                badge.textContent = status.label;
                statusBorders.forEach((cls) => card.classList.remove(cls));
                card.classList.add(status.borderClass);
                card.dataset.status = statusKey;
            };

            const handleAccept = (btn) => {
                const card = btn.closest('[data-order-id]');
                const orderId = card.dataset.orderId;
                const now = new Date();
                orderMap[orderId] = {
                    ...orderMap[orderId],
                    status: 'in_progress',
                    started_at: now.toISOString()
                };
                card.querySelector('.start-time').textContent = formatTime(now);
                updateStatus(card, 'in_progress');
                btn.disabled = true;
            };

            const handleDone = (btn) => {
                const card = btn.closest('[data-order-id]');
                const orderId = card.dataset.orderId;
                orderMap[orderId] = {
                    ...orderMap[orderId],
                    status: 'done'
                };
                updateStatus(card, 'done');
                btn.disabled = true;
                const acceptBtn = card.querySelector('.accept-btn');
                if (acceptBtn) acceptBtn.disabled = true;
                card.classList.add('opacity-75');
            };

            const renderPrint = (order) => {
                if (!order) return;
                const itemsHtml = (order.items || [])
                    .map((item) => `<li>${item.name} x${item.qty}</li>`)
                    .join('');

                printArea.innerHTML = `
            <div class="print-slip">
                <h5>ใบออเดอร์ครัว</h5>
                <div>โต๊ะ: <strong>${order.table}</strong></div>
                <div>หมายเลขออเดอร์: <strong>${order.order_no}</strong></div>
                <div>เวลา: ${formatTime(order.placed_at)}</div>
                <hr />
                <div><strong>รายการอาหาร</strong></div>
                <ul>${itemsHtml}</ul>
                ${order.note ? `<div>หมายเหตุ: ${order.note}</div>` : ''}
            </div>
        `;
                window.print();
            };

            document.querySelectorAll('.accept-btn').forEach((btn) => {
                btn.addEventListener('click', () => handleAccept(btn));
            });

            document.querySelectorAll('.done-btn').forEach((btn) => {
                btn.addEventListener('click', () => handleDone(btn));
            });

            document.querySelectorAll('.print-btn').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const card = btn.closest('[data-order-id]');
                    const order = orderMap[card.dataset.orderId];
                    renderPrint(order);
                });
            });

            const lastRefresh = document.getElementById('last-refresh');
            const refreshTick = () => {
                if (lastRefresh) lastRefresh.textContent = formatTime(new Date());
            };
            refreshTick();
            setInterval(refreshTick, 15000);
            const refreshBtn = document.getElementById('refresh-btn');
            if (refreshBtn) refreshBtn.addEventListener('click', refreshTick);
        })();
    </script>

</body>

</html>