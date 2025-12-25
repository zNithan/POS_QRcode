<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Admin Add ได้', 'redirect', 'SET');
$oUser = login_logout::getLoginData();
if ($oUser->status != 'admin') {
	setRaiseMsg('Only advanced administrators can add New members can.', _TIME_, 1);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=admin");
	exit;
}
$keysname = REQ_get('keysname', 'request', 'str', '');

///////////////////////////////////////////////////////
/////////////////// isSecurMode /////////////////////
///////////////////////////////////////////////////////
$isSecurMode = GlobalConfig_get('isSecurMode');
if (in_array(_AC_, array('saveedit', 'save', 'add', 'edit', 'delete')) && $isSecurMode == 1) {
	setRaiseMsg('Secur Mode.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=admin");
	exit;
}
///////////////////////////////////////////////////////
/////////////////// isSecurMode /////////////////////
///////////////////////////////////////////////////////
if (_AC_ == 'save') {
	PERMIT::_PERMIT(_MODULE_, 'You can add/edit/del admin', 'สามารถ เพิ่ม แก้ไข ลบ Admin ได้', 'redirect', '');
	$firstname 	= REQ_get('firstname', 'request', 'str', '');
	$lastname 	= REQ_get('lastname', 'request', 'str', '');
	$phone 		= REQ_get('phone', 'request', 'str', '');
	$username 	= REQ_get('username', 'request', 'str', '');
	$password 	= REQ_get('password', 'request', 'str', '');
	$status 	= REQ_get('status', 'request', 'str', 'admin');
	$email 		= REQ_get('email', 'request', 'str', '');
	$mlist 		= REQ_get('mlist', 'request', 'array', '');
	$checkall 	= REQ_get('checkall', 'request', 'array', '');

	if (in_array($username, $aConfig['aUserDisable'])) {
		setRaiseMsg('Cannot use USERNAME.', _TIME_, 1);
		CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
		exit;
	}

	if (checkUsernameIsExists($username) == true && $username != '') {
		setRaiseMsg('With USERNAME already in the system.', _TIME_, 1);
		CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
		exit;
	}
	if ($username == 'superadmin' || $username == 'admin') {
		$strModules = 'all';
	}
	if (!empty($checkall)) {
		$strModules = 'all';
	} elseif ($mlist != '' && count($mlist) > 0 && !in_array('all', $mlist)) {
		$strModules = implode(',', $mlist);
	} else {
		$strModules = '';
	}

	if ($firstname == '' || $lastname == '' || $username == '' || $password == '' || $email == '') {
		setRaiseMsg('Please complete the information. (*).', _TIME_, 1);
		CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
		exit;
	}

	$password = _builpassword($password);   ///ตัวอย่าง
	$a = array();
	$a['user_id'] = NULL;
	$a['username'] = $username;
	$a['password'] = $password;
	$a['status'] = $status;
	$a['node_member'] = 0;
	$a['ipaddress'] = getIP();
	$a['register_date'] = _TIME_;
	$a['modules'] = $strModules;

	$id = DB_ADD('member_user', $a);

	$a = array();
	$a['mem_id'] = NULL;
	$a['user_id'] = 	$id;
	$a['firstname'] = $firstname;
	$a['lastname'] = $lastname;
	$a['email'] = $email;
	$a['phone'] = $phone;
	$a['mem_code'] = 0;

	$id = DB_ADD('member_member', $a);
	$pic = @$_FILES['picture'];
	$extention = end(explode('.', $pic['name']));
	$extention = strtolower($extention);
	if ($extention == 'jpg' || $extention == 'png') {
		$namepic = 'member/' . $id . '.' . $extention;
		$filePic = PATH_UPLOAD . '/' . $namepic;
		if (is_file($filePic)) {
			unlink($filePic);
		}

		if (move_uploaded_file($pic['tmp_name'], $filePic)) {
			DB_UP('member_member', ['picture' => $namepic], ['user_id' => $id]);
		}
	}
	Func_Addlogs("[Member] Add Admin ID {$id} ");
	setRaiseMsg('Adding the login information successfully.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=admin");
	exit;
}
?>
<style>
	.field-icon {
		float: right;
		margin-right: 10px;
		margin-top: -25px;
		position: relative;
		z-index: 2;
		color: #888;
	}
</style>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow">Create Admin User</h1>
	</div>
</div>
<form name="thisform" action="" id="form1" method="post" enctype="multipart/form-data">
	<div id="page-content">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Add administrator</h3>
					</div>
					<div class="panel-body">
						<?php displayRaiseMsg(); ?>
						<div class="form-group">
							<label for="demo-inline-inputmail" class="sr-only">Admin name</label>
							<input type="text" name="firstname" placeholder="Admin name" id="demo-inline-inputmail" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail" class="sr-only">admin lastname</label>
							<input type="text" name="lastname" placeholder="Lastname" id="demo-inline-inputmail" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label for="phone" class="sr-only">Phone</label>
							<input type="text" name="phone" placeholder="Phone" id="phone" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputmail" class="sr-only">Email address</label>
							<input type="email" name="email" placeholder="Enter email" id="demo-inline-inputmail" class="form-control" required="required">
						</div>
						<p class="bord-btm pad-ver text-main text-bold">Login</p>
						<div class="form-group">
							<label for="demo-inline-inputmail" class="sr-only">Username</label>
							<input type="text" name="username" placeholder="Username" id="demo-inline-inputmail" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label for="demo-inline-inputpass" class="sr-only">Password</label>
							<input type="password" name="password" placeholder="Password" id="password" class="form-control" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,30}$" title="Password must have at least 8 character length with minimum 1 uppercase, 1 lowercase, 1 number and 1 special characters.">
							<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" onclick="dpass('toggle-password', 'password');"></span>
						</div>
						<div class="form-group">
							<label for="demo-inline-inputpass" class="sr-only">Password Confirm</label>
							<input type="password" name="password2" placeholder="Password Confirm" id="password2" class="form-control" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,30}$" title="Password must have at least 8 character length with minimum 1 uppercase, 1 lowercase, 1 number and 1 special characters.">
							<span class="fa fa-fw fa-eye field-icon toggle-password2" onclick="dpass('toggle-password2', 'password2');"></span>
						</div>
						<div class="form-group">
							<ul id="cmessage">
								<li id="clangth">จำนวนตัวอักษร 8 ตัวขึ้นไป</li>
								<li id="cletter">ต้องมีตัวพิมพ์เล็กอย่างน้อย 1 ตัว</li>
								<li id="ccapital">ต้องมีตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว</li>
								<li id="cspacialchar">ต้องมีอักขระพิเศษอย่างน้อย 1 ตัว</li>
								<li id="cnumber">ต้องมีตัวเลขอย่างน้อย 1 ตัว</li>
								<li id="comfpass">ยืนยันรหัสผ่านตรงกัน</li>
							</ul>
						</div>
						<p class="bord-btm pad-ver text-main text-bold">Picture</p>
						<div class="form-group">
							<span class="pull-left btn btn-dark btn-file dbfont19">
								<i class="demo-pli-upload-to-cloud icon-5x" style="font-size: 18px;"></i>Choose a personal picture... <input type="file" name="picture" onchange="readURL(this);">
							</span>
						</div>
						<br clear="all">
						<button type="submit" class="btn btn-mint" name="Create Admin" value="Create Admin" style="margin-top: 10px">Create Admin</button>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Permissions</h3>
					</div>
					<div class="panel-body">
						<div class="checkbox">
							<input class="magic-checkbox checkall" type="checkbox" name="checkall[]" onclick="return checkAllList();" id="checkallpermission">
							<label for="checkallpermission">Enable all permissions</label>
						</div>
						<?php
						$permit = PERMIT::PERMIT_GET();
						if (isset($permit)) {
							foreach ($permit as $k => $v) { ?>
								<div class="bord-btm pad-ver col-xs-12 checkbox">
									<input class="magic-checkbox checkallmodule checkall-<?php echo md5($k); ?>" type="checkbox" onclick="return checkAllModule('<?php echo md5($k); ?>');" id="checkallmodule-<?php echo md5($k); ?>">
									<label for="checkallmodule-<?php echo md5($k); ?>">
										<p class="text-main text-bold"><?php echo strtoupper($k); ?></p>
									</label>
								</div>
								<?php foreach ($v as $kk => $vv) { ?>
									<div class="col-xs-4">
										<div class="form-group checkbox">
											<input class="permissioncheck magic-checkbox checkpoint <?php echo md5($k); ?>" type="checkbox" name="mlist[]" value="<?php echo $kk; ?>" id="permission-<?php echo md5($kk . $vv); ?>" />
											<label for="permission-<?php echo md5($kk . $vv); ?>"><?php echo $vv; ?></label>
										</div>
									</div>
								<?php } ?>
						<?php }
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" name="ac" value="save">
</form>

<script>
	function showPermissionDisplay() {
		if (document.getElementById('radioStatusAdmin').checked) {
			$('.adminshow').fadeIn();
			$('.operatorshow').fadeOut();
		} else {
			$('.operatorshow').fadeIn();
			$('.adminshow').fadeOut();
		}
	}
</script>