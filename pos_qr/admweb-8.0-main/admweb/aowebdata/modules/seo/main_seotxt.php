<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp|keysname', 'สามารถใช้ Addon Script ได้', 'redirect', 'SET');
$lang 	  = getCurrentLang();
$mp		  = REQ_get('mp', 'request', 'str', '');
$module	  = REQ_get('module', 'request', 'str', '');
$ac 	  = REQ_get('ac', 'request', 'str', '');
$inc 	  = REQ_get('inc', 'request', 'str', 'config');
$keysname = REQ_get('keysname', 'request', 'str', 'config');

$isSecurMode = GlobalConfig_get('isSecurMode');
if (in_array($ac, array('del','updateBeforCloseHeader', 'updateAfterOpenBody', 'updateBeforCloseBody')) && $isSecurMode == 1) {
	setRaiseMsg('Secur Mode.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=seotxt");
	exit;
}

if ($ac == 'del') {
	$keys 	  = REQ_get('keys', 'request', 'str', '');
	if (in_array($keys, array('AddOnScriptBeforCloseHeader', 'AddOnScriptAfterOpenBody', 'AddOnScriptBeforCloseBody'))) {
		$aData = DB_GET('site_configs', ['keywords' => $keys]);
		if ($aData['val'] != '') {
			DB_UP('site_configs', ['val' => ''], ['keywords' => $keys]);
		}

		if (PATH_UPLOAD.'/config_file/'.$keys.'.html') {
			unlink(PATH_UPLOAD.'/config_file/'.$keys.'.html');
		}
	}
	setRaiseMsg('Clear text.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=seotxt");
	exit;
}

if ($ac == 'updateBeforCloseHeader') {
	$BeforCloseHeader 	  = REQ_get('BeforCloseHeader', 'file', '', '');
	$aData = DB_GET('site_configs', ['keywords' => 'AddOnScriptBeforCloseHeader']);
	if (count($aData) == 0) {
		$a = array();
		$a['conf_id'] = NULL;
		$a['keywords'] = 'AddOnScriptBeforCloseHeader';
		$a['val'] = ' ';
		DB_ADD('site_configs', $a);
	}

	if ($BeforCloseHeader['name'] != '' && $BeforCloseHeader['error'] == 0) {
		$extention = end(explode('.', $BeforCloseHeader['name']));
		$extention = strtolower($extention);
		if ($extention == 'txt') {
			$fup = 'config_file/AddOnScriptBeforCloseHeader.html';
			$fileAttc = PATH_UPLOAD . '/' . $fup;
			if (is_file($fileAttc)) {
				unlink($fileAttc);
			}
			if (move_uploaded_file($BeforCloseHeader['tmp_name'], $fileAttc)) {
				DB_UP('site_configs', ['val' => $fup], ['keywords' => 'AddOnScriptBeforCloseHeader']);
			}
		}
	}

	setRaiseMsg('Befor close header change text.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=seotxt");
	exit;
}

if ($ac == 'updateAfterOpenBody') {
	$AfterOpenBody 	  = REQ_get('AfterOpenBody', 'file', '', '');
	$aData = DB_GET('site_configs', ['keywords' => 'AddOnScriptAfterOpenBody']);
	if (count($aData) == 0) {
		$a = array();
		$a['conf_id'] = NULL;
		$a['keywords'] = 'AddOnScriptAfterOpenBody';
		$a['val'] = ' ';
		DB_ADD('site_configs', $a);
	}

	if ($AfterOpenBody['name'] != '' && $AfterOpenBody['error'] == 0) {
		$extention = end(explode('.', $AfterOpenBody['name']));
		$extention = strtolower($extention);
		if ($extention == 'txt') {
			$fup = 'config_file/AddOnScriptAfterOpenBody.html';
			$fileAttc = PATH_UPLOAD . '/' . $fup;
			if (is_file($fileAttc)) {
				unlink($fileAttc);
			}
			if (move_uploaded_file($AfterOpenBody['tmp_name'], $fileAttc)) {
				DB_UP('site_configs', ['val' => $fup], ['keywords' => 'AddOnScriptAfterOpenBody']);
			}
		}
	}

	setRaiseMsg('After open body change text.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=seotxt");
	exit;
}

if ($ac == 'updateBeforCloseBody') {
	$BeforCloseBody 	  = REQ_get('BeforCloseBody', 'file', '', '');
	$aData = DB_GET('site_configs', ['keywords' => 'AddOnScriptBeforCloseBody']);
	if (count($aData) == 0) {
		$a = array();
		$a['conf_id'] = NULL;
		$a['keywords'] = 'AddOnScriptBeforCloseBody';
		$a['val'] = ' ';
		DB_ADD('site_configs', $a);
	}

	if ($BeforCloseBody['name'] != '' && $BeforCloseBody['error'] == 0) {
		$extention = end(explode('.', $BeforCloseBody['name']));
		$extention = strtolower($extention);
		if ($extention == 'txt') {
			$fup = 'config_file/AddOnScriptBeforCloseBody.html';
			$fileAttc = PATH_UPLOAD . '/' . $fup;
			if (is_file($fileAttc)) {
				unlink($fileAttc);
			}
			if (move_uploaded_file($BeforCloseBody['tmp_name'], $fileAttc)) {
				DB_UP('site_configs', ['val' => $fup], ['keywords' => 'AddOnScriptBeforCloseBody']);
			}
		}
	}

	setRaiseMsg('Befor close body change text.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=seotxt");
	exit;
}

?>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow">AddOn Script</h1>
	</div>
</div>
<div id="page-content">
	<div class="row">
		<div class="col-xs-12"><?php displayRaiseMsg(); ?></div>
		<div class="col-md-4">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
				<input name="ac" type="hidden" value="updateBeforCloseHeader" />
				<?php $AddOnScriptBeforCloseHeader = DB_GET('site_configs', ['keywords' => 'AddOnScriptBeforCloseHeader']); ?>
				<div class="panel">
					<div class="panel-body">
						<h3>Befor Close Header</h3>
						<div class="form-group">
							<textarea rows="25" class="form-control" name="" readonly><?php if (isset($AddOnScriptBeforCloseHeader['val']) && $AddOnScriptBeforCloseHeader['val'] != '' && file_exists(PATH_UPLOAD . '/' . $AddOnScriptBeforCloseHeader['val'])) {
																							include(PATH_UPLOAD . '/' . $AddOnScriptBeforCloseHeader['val']);
																						} ?></textarea>
						</div>
						<div class="form-group">
							<div id="getPathShowBeforCloseHeader"></div>
							<span class="btn btn-primary btn-file">แนบไฟล์ script นามสกุล .txt
								<input type="file" id="BeforCloseHeader" name="BeforCloseHeader" accept="text/*" onchange="get2Path('BeforCloseHeader', 'getPathShowBeforCloseHeader');">
							</span>
							<?php if (isset($AddOnScriptBeforCloseHeader['val']) && trim($AddOnScriptBeforCloseHeader['val']) != '') { ?>
							<a class="btn btn-danger" href="<?php echo _admin_buil_link('index.php?module='._MODULE_.'&mp='._MP_.'&ac=del&keys=AddOnScriptBeforCloseHeader'); ?>" onclick="return confirm('Please confirm clear text');">Clear content</a>
							<?php } ?>
						</div>
						<button class="btn btn-mint submit" style="font-size: 24px; font-family: db_ozone_xregular; "> <i class="fa fa-save" style="font-size: 18px;"></i> Update</button>
						<br><br>
						<pre><div>การนำไปใช้งาน</div><div><?php echo htmlspecialchars("<?php AddOnScript('AddOnScriptBeforCloseHeader'); ?>", ENT_QUOTES); ?></div></pre>
					</div>
				</div>
			</form>
		</div>

		<div class="col-md-4">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
				<input name="ac" type="hidden" value="updateAfterOpenBody" />
				<?php $AddOnScriptAfterOpenBody = DB_GET('site_configs', ['keywords' => 'AddOnScriptAfterOpenBody']); ?>
				<div class="panel">
					<div class="panel-body">
						<h3>After Open Body</h3>
						<div class="form-group">
							<textarea rows="25" class="form-control" name="" readonly><?php if (isset($AddOnScriptAfterOpenBody['val']) && $AddOnScriptAfterOpenBody['val'] != '' && file_exists(PATH_UPLOAD . '/' . $AddOnScriptAfterOpenBody['val'])) {
																							include(PATH_UPLOAD . '/' . $AddOnScriptAfterOpenBody['val']);
																						} ?></textarea>
						</div>
						<div class="form-group">
							<div id="getPathShowAfterOpenBody"></div>
							<span class="btn btn-primary btn-file">แนบไฟล์ script นามสกุล .txt
								<input type="file" id="AfterOpenBody" name="AfterOpenBody" accept="text/*" onchange="get2Path('AfterOpenBody', 'getPathShowAfterOpenBody');">
							</span>
							<?php if (isset($AddOnScriptAfterOpenBody['val']) && trim($AddOnScriptAfterOpenBody['val']) != '') { ?>
							<a class="btn btn-danger" href="<?php echo _admin_buil_link('index.php?module='._MODULE_.'&mp='._MP_.'&ac=del&keys=AddOnScriptAfterOpenBody'); ?>" onclick="return confirm('Please confirm clear text');">Clear content</a>
							<?php } ?>
						</div>
						<button class="btn btn-mint submit" style="font-size: 24px; font-family: db_ozone_xregular; "> <i class="fa fa-save" style="font-size: 18px;"></i> Update</button>
						<br><br>
						<pre><div>การนำไปใช้งาน</div><div><?php echo htmlspecialchars("<?php AddOnScript('AddOnScriptAfterOpenBody'); ?>", ENT_QUOTES); ?></div></pre>
					</div>
				</div>
			</form>
		</div>

		<div class="col-md-4">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
				<input name="ac" type="hidden" value="updateBeforCloseBody" />
				<?php $AddOnScriptBeforCloseBody = DB_GET('site_configs', ['keywords' => 'AddOnScriptBeforCloseBody']); ?>
				<div class="panel">
					<div class="panel-body">
						<h3>Befor Close Body</h3>
						<div class="form-group">
							<textarea rows="25" class="form-control" name="" readonly><?php if (isset($AddOnScriptBeforCloseBody['val']) && $AddOnScriptBeforCloseBody['val'] != '' && file_exists(PATH_UPLOAD . '/' . $AddOnScriptBeforCloseBody['val'])) {
																							include(PATH_UPLOAD . '/' . $AddOnScriptBeforCloseBody['val']);
																						} ?></textarea>
						</div>
						<div class="form-group">
							<div id="getPathShowBeforCloseBody"></div>
							<span class="btn btn-primary btn-file">แนบไฟล์ script นามสกุล .txt
								<input type="file" id="BeforCloseBody" name="BeforCloseBody" accept="text/*" onchange="get2Path('BeforCloseBody', 'getPathShowBeforCloseBody');">
							</span>
							<?php if (isset($AddOnScriptBeforCloseBody['val']) && trim($AddOnScriptBeforCloseBody['val']) != '') { ?>
							<a class="btn btn-danger" href="<?php echo _admin_buil_link('index.php?module='._MODULE_.'&mp='._MP_.'&ac=del&keys=AddOnScriptBeforCloseBody'); ?>" onclick="return confirm('Please confirm clear text');">Clear content</a>
							<?php } ?>
						</div>
						<button class="btn btn-mint submit" style="font-size: 24px; font-family: db_ozone_xregular; "> <i class="fa fa-save" style="font-size: 18px;"></i> Update</button>
						<br><br>
						<pre><div>การนำไปใช้งาน</div><div><?php echo htmlspecialchars("<?php AddOnScript('AddOnScriptBeforCloseBody'); ?>", ENT_QUOTES); ?></div></pre>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>