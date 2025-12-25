<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Emailconnect ได้', 'redirect', 'SET');
if (_AC_ == 'changesmtp') {
	$isSmtp = (@$_REQUEST['isSmtp'] == 1) ? 1 : 0;
	GlobalConfig_update_config_keys('isSmtp', $isSmtp);
	setRaiseMsg('บันทึกข้อมูล .', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
	exit;
}
$isSmtp = GlobalConfig_get('isSmtp', 0);
$smtp_host = GlobalConfig_get('smtp_host');
$smtp_port = GlobalConfig_get('smtp_port');
$smtp_user = GlobalConfig_get('smtp_user');
$smtp_pass = GlobalConfig_get('smtp_pass');
$smtp_sender = GlobalConfig_get('smtp_sender');
$smtp_sendername = GlobalConfig_get('smtp_sendername');
$SMTPSecure = GlobalConfig_get('SMTPSecure');

if ($isSmtp == 1) {
	$changeTo = 0;
	$btnClass = 'fa-toggle-on';
} else {
	$changeTo = 1;
	$btnClass = 'fa-toggle-off';
}
?>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow">E-mail Connection</h1>
	</div>
	<ol class="breadcrumb">
		<li><a href="#"><i class="demo-pli-home"></i></a></li>
		<li class="active">E-mail Connection</li>
	</ol>
</div>
<div id="page-content">
	<div class="row">
		<div class="col-lg-12"><?php displayRaiseMsg(); ?></div>
		<div class="col-lg-3">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">SMTP Config</h3>
				</div>
				<div class="panel-body">
					<form id="savesmtp" action="">
						<input type="hidden" name="ac" value="save">
						<div class="form-group">
							<a href="<?php echo _admin_buil_link('index.php?module=' . _MODULE_ . '&mp=' . _MP_ . '&ac=changesmtp&isSmtp=' . $changeTo); ?>"><i class="fa <?php echo $btnClass; ?>" style="font-size: 24px;color: #8BC34A;"></i> ใช้งาน SMTP</a>
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">SMTP Host (192.168.250.81)</label>
							<input type="text" class="form-control" name="smtp_host" value="<?php echo $smtp_host; ?>">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">SMTP Port (25)</label>
							<input type="text" class="form-control" name="smtp_port" value="<?php echo $smtp_port; ?>">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">SMTP Username</label>
							<input type="text" class="form-control" name="smtp_user" value="<?php echo $smtp_user; ?>">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">SMTP Password</label>
							<input type="text" class="form-control" name="smtp_pass" value="<?php echo $smtp_pass; ?>">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">SMTP Secure</label>
							<select name="SMTPSecure" class="form-control">
								<option <?php echo ($SMTPSecure == '') ? ' selected="selected" ' : ''; ?> value="">NONE</option>
								<option <?php echo ($SMTPSecure == 'tls') ? ' selected="selected" ' : ''; ?> value="tls">TLS</option>
								<option <?php echo ($SMTPSecure == 'ssl') ? ' selected="selected" ' : ''; ?> value="ssl">SSL</option>
							</select>
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">ชื่อใช้ส่งออก</label>
							<input type="text" class="form-control" name="smtp_sendername" value="<?php echo $smtp_sendername; ?>">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">อีเมล์ใช้ส่งออกจากระบบ</label>
							<input type="text" class="form-control" name="smtp_sender" value="<?php echo $smtp_sender; ?>">
						</div>
						<div class="form-group"><button type="button" class="btn btn-primary" onclick="TestSentEmail('savesmtp');">บันทึกข้อมูล</button></div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">TEST Sent Mail</h3>
				</div>
				<div class="panel-body" style="min-height: 551px;">
					<form action="" id="formtestmail">
						<div class="form-group">
							<label for="demo-inline-inputmail">ผู้ส่ง</label>
							<input type="text" class="form-control sender2" value="<?php echo $smtp_sender; ?>" readonly="readonly">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">Email ผู้รับ</label>
							<input id="mailto" name="mailto" type="text" class="form-control" value="">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">Subject</label>
							<input id="title" name="title" type="text" class="form-control" value="Test sent email form web">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail">Message</label>
							<textarea id="message" name="message" rows="11" cols="" class="form-control"></textarea>
						</div>
						<div class="form-group"><button type="button" id="gotestmain" class="btn btn-primary" onclick="TestSentEmail('formtestmail');">ส่งเมล์ทดสอบ</button></div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">History Test</h3>
				</div>
				<div class="panel-body">
					<div class="HistoryTest">ยังไม่มีข้อมูล</div>
					<div class="loading" align="center" style="padding: 30px;display: none;">
						<style>
							.lds-facebook {
								display: inline-block;
								position: relative;
								width: 50px;
								height: 50px;
							}

							.lds-facebook div {
								display: inline-block;
								position: absolute;
								left: 8px;
								width: 16px;
								background: #CCCCCC;
								animation: lds-facebook 1.1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
							}

							.lds-facebook div:nth-child(1) {
								left: 8px;
								animation-delay: -0.24s;
							}

							.lds-facebook div:nth-child(2) {
								left: 32px;
								animation-delay: -0.12s;
							}

							.lds-facebook div:nth-child(3) {
								left: 56px;
								animation-delay: 0;
							}

							@keyframes lds-facebook {
								0% {
									top: 8px;
									height: 64px;
								}

								50%,
								100% {
									top: 24px;
									height: 32px;
								}
							}
						</style>
						<div class="lds-facebook">
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>