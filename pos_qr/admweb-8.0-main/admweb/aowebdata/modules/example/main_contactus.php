<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Contact Us Mail ได้', 'redirect', 'SET');
$id 	= REQ_get('id', 'request', 'int', '');
$getALlContact = DB_LIST('contact', [], 0, 1, " ORDER BY add_date ASC");
if (_AC_ == 'del') {
	PERMIT::_PERMIT(_MODULE_, 'module|mp|ac', 'สามารถลบ Contact Us Mail ได้', 'redirect', 'SET');
	DB_DEL('contact', ['id' => $id]);
	setRaiseMsg('ลบข้อมูลการติดต่อเรียบร้อยแล้ว.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
	exit;
}

?>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow"></h1>
	</div>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="demo-pli-home"></i></a></li>
		<li><a class="active" href="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . ""); ?>">รายการติดต่อ</a></li>
	</ol>
</div>

<div id="page-content">
	<div class="row">
		<?php displayRaiseMsg(); ?>
		<div class="col-lg-12">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">รายการติดต่อ ทั้งหมด</h3>
				</div>

				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="100">No</th>
									<th>ชื่อ - นามสกุล</th>
									<th>อีเมล</th>
									<th>ติดต่อจากหน้า</th>
									<th>เรื่องที่ติดต่อ</th>
									<th>รายละเอียด</th>
									<th>วันที่ติดต่อ</th>
									<th class="text-center">จัดการ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 0;
								foreach ($getALlContact['data'] as $v) {
									$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $v['first_last']; ?></td>
										<td><?php echo $v['email']; ?></td>
										<td><?php echo ($v['url'] != '') ? $v['url'] : '-'; ?></td>
										<td><?php echo $v['subject']; ?></td>
										<td><?php echo $v['message']; ?></td>
										<td><?php echo date('d/m/y', strtotime($v['add_date'])); ?></td>
										<td class="text-center">
											<a class="label label-table label-danger" onclick="return confirm('Delete this selected ?');" href="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ac=del&id=" . $v['id']); ?>">ลบ</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<hr class="new-section-xs">
				</div>
			</div>
		</div>
	</div>
</div>