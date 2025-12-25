<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Admin Edit ได้', 'redirect', 'SET');
$id = REQ_get('id', 'request', 'int', '');
$keysname = REQ_get('keysname', 'request', 'str', '');
$oUser = login_logout::getAdminId();
if ($oUser != 1 && $id == 1) {
	login_logout::reDirectToLogin('index.php');
	exit;
}
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

if (_AC_ == 'saveedit') {
	PERMIT::_PERMIT(_MODULE_, 'You can add/edit/del admin', 'สามารถ เพิ่ม แก้ไข ลบ Admin ได้', 'redirect', '');
	$firstname 	= REQ_get('firstname', 'request', 'str', '');
	$lastname 	= REQ_get('lastname', 'request', 'str', '');
	$phone 		= REQ_get('phone', 'request', 'str', '');
	$username 	= REQ_get('username', 'post', 'str', '');
	$password 	= REQ_get('password', 'post', 'str', '');
	$status 	= REQ_get('status', 'post', 'str', 'admin');
	$email 		= REQ_get('email', 'request', 'str', '');
	$mlist 		= REQ_get('mlist', 'request', 'array');
	$checkall 	= REQ_get('checkall', 'request', 'array', '');

	if ($username == 'superadmin' || $username == 'admin') {
		$strModules = 'all';
	} elseif (!empty($checkall)) {
		$strModules = 'all';
	} elseif ($mlist != '' && count($mlist) > 0 && !in_array('all', $mlist)) {
		$strModules = implode(',', $mlist);
	} else {
		$strModules = '';
	}

	if ($firstname == '' || $lastname == '' || $username == '' || $email == '') {
		setRaiseMsg('Please complete the information. (*).', _TIME_, 1);
		CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&id=" . $id);
		exit;
	}

	if (Func_CheckUser_Exists($id, $username) == true) {
		setRaiseMsg('For maximum security, this username cannot be used because it is repeated with other members or administrators..', _TIME_, 1);
		CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&id=" . $id);
		exit;
	}

	DB_UP('member_member', [
		'firstname' => $firstname,
		'lastname' => $lastname,
		'email' => $email,
		'phone' => $phone
	], ['user_id' => $id]);

	DB_UP('member_user', [
		'username' => $username,
		'status' => $status,
		'modules' => $strModules
	], ['user_id' => $id]);

	if (@$_REQUEST['changepassword'] == 1) {
		$password = _builpassword($password);
		DB_UP('member_user', ['password' => $password], ['user_id' => $id]);
	}

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
	Func_Addlogs("[Member] Edit Admin ID {$id}");
	setRaiseMsg('Editing information completed.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&id=" . $id);
	exit;
}

$a = DB_GET('member_member', ['user_id' => $id], '');
if (!isset($a['user_id'])) {
	$add = array();
	//$add['mem_id'] = NULL;
	$add['user_id'] = $id;

	DB_ADD('member_member', $add);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&id=" . $id);
	exit;
}

$row3 = getAdminUserById($id);
$row3['mlist'] = explode(',', @$row3['modules']);
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
		<h1 class="page-header text-overflow">Edit Admin User</h1>
	</div>
</div>
<form name="thisform" id="form1" action="" method="post" autocomplete="off" enctype="multipart/form-data">
	<div id="page-content">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Edit admin info</h3>
					</div>
					<div class="panel-body">
						<?php displayRaiseMsg(); ?>
						<div class="form-group">
							<label class="sr-only">Admin name</label>
							<input type="text" name="firstname" value="<?php echo $row3['firstname']; ?>" placeholder="Admin name" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label class="sr-only">Admin lastname</label>
							<input type="text" name="lastname" value="<?php echo $row3['lastname']; ?>" placeholder="Admin lastname" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label class="sr-only">phone</label>
							<input type="text" name="phone" value="<?php echo $row3['phone']; ?>" placeholder="Phone" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label class="sr-only">Email address</label>
							<input type="email" name="email" value="<?php echo $row3['email']; ?>" placeholder="Enter email" class="form-control" required="required">
						</div>
						<p class="bord-btm pad-ver text-main text-bold">Login</p>
						<div class="form-group">
							<label class="sr-only">Username</label>
							<input type="text" name="username" value="<?php echo $row3['username']; ?>" placeholder="Username" class="form-control" required="required">
						</div>
						<div class="form-group">
							<label class="sr-only">Password</label>
							<input type="password" name="password" disabled="disabled" placeholder="Password" id="password" class="form-control changepasscheck" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,30}$" title="Password must have at least 8 character length with minimum 1 uppercase, 1 lowercase, 1 number and 1 special characters.">
						</div>
						<div class="form-group">
							<label class="sr-only">Password Confirm</label>
							<input type="password" name="password2" disabled="disabled" placeholder="Password Confirm" id="password2" class="form-control changepasscheck2" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,30}$" title="Password must have at least 8 character length with minimum 1 uppercase, 1 lowercase, 1 number and 1 special characters.">
						</div>
						<input type="checkbox" id="changepassword" name="changepassword" value="1" onclick="changepasscheck(this)"> Choose if you want to change your password.
						<p class="bord-btm pad-ver text-main text-bold">Picture</p>
						<div class="form-group">
							<?php
							if ($row3['picture'] != '') {
								$userPic = Func_Pic_Corp($row3['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
							?>
								<div class="text-left" style="margin-bottom: 10px;"><img alt="Profile" src="<?php echo $userPic; ?>?time=<?php echo _TIME_; ?>" class="img-circle img-lg"></div>
							<?php } ?>
							<span class="pull-left btn btn-dark btn-file dbfont19">
								<i class="demo-pli-upload-to-cloud icon-5x" style="font-size: 18px;"></i>Choose a personal picture... <input type="file" name="picture" onchange="readURL(this);">
							</span>
							<div class="displayselect" style="display: none;"><br clear="all"><br clear="all"><img src="" class="blah" width="150"></div>
						</div>
						<hr class="new-section-sm bord-no">
						<div class="form-group">
							<button type="submit" class="btn btn-mint" name="Edit User Admin" value="Edit User Admin">Edit User Admin</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Permission</h3>
					</div>
					<div class="panel-body">
						<div class="checkbox" style="margin-bottom:30px">
							<?php $seall = (in_array('all', $row3['mlist'])) ? ' checked="checked" ' : ''; ?>
							<input <?php echo $seall; ?> class="magic-checkbox checkall" type="checkbox" name="checkall[]" onclick="return checkAllList();" id="checkallpermission">
							<label for="checkallpermission">Enable all permissions</label>
						</div>
						<?php
						$permit = PERMIT::PERMIT_GET();
						if (isset($permit)) {
							$semo = ($seall === ' checked="checked" ') ? ' disabled' : '';
							foreach ($permit as $k => $v) { ?>
								<div class="bord-btm pad-ver col-xs-12 checkbox">
									<input <?php echo $semo; ?> class="magic-checkbox checkallmodule checkall-<?php echo md5($k); ?>" type="checkbox" onclick="return checkAllModule('<?php echo md5($k); ?>');" id="checkallmodule-<?php echo md5($k); ?>">
									<label for="checkallmodule-<?php echo md5($k); ?>">
										<p class="text-main text-bold"><?php echo strtoupper($k); ?></p>
									</label>
								</div>
								<?php foreach ($v as $kk => $vv) { ?>
									<div class="col-xs-4">
										<?php
										$se = (in_array($kk, $row3['mlist']) || in_array('all', $row3['mlist'])) ? ' checked="checked" ' : '';
										?>
										<div class="form-group checkbox">
											<input class="permissioncheck magic-checkbox checkpoint <?php echo md5($k); ?>" type="checkbox" <?php echo $se; ?> name="mlist[]" value="<?php echo $kk; ?>" id="permission-<?php echo md5($kk . $vv); ?>" />
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
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="ac" value="saveedit">
</form>

<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('.blah')
					.attr('src', e.target.result).width(150);
			};

			reader.readAsDataURL(input.files[0]);
		}
		$('.displayselect').fadeIn();
	}

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