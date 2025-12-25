<?php
if (_AC_ == 'save') {
	$smtp_host 		= @$_REQUEST['smtp_host'];
	$smtp_port 			= @$_REQUEST['smtp_port'];
	$smtp_user 		= @$_REQUEST['smtp_user'];
	$smtp_pass 		= @$_REQUEST['smtp_pass'];
	$smtp_sender 	= @$_REQUEST['smtp_sender'];
	$smtp_sendername 	= @$_REQUEST['smtp_sendername'];
	$SMTPSecure 	= @$_REQUEST['SMTPSecure'];

	GlobalConfig_update_config_keys('smtp_host', $smtp_host);
	GlobalConfig_update_config_keys('smtp_port', $smtp_port);
	GlobalConfig_update_config_keys('smtp_user', $smtp_user);
	GlobalConfig_update_config_keys('smtp_pass', $smtp_pass);
	GlobalConfig_update_config_keys('smtp_sendername', $smtp_sendername);
	GlobalConfig_update_config_keys('smtp_sender', $smtp_sender);
	GlobalConfig_update_config_keys('SMTPSecure', $SMTPSecure);

	unset($_REQUEST['module']);
	unset($_REQUEST['mp']);
	unset($_REQUEST['ac']);
	$_REQUEST['smtp_pass'] = '***hidden***';

	pre($_REQUEST);

	echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
	exit;
}

if (_AC_ == 'test') {
	if (@$_REQUEST['mailto'] == '') {
		echo '001 กรุณากรอกอีเมล์ผู้รับปลายทาง';
		pre($_POST);
		exit;
	}

	if (@$_REQUEST['title'] == '') {
		echo '002 กรุณากรอก Subject Mail ด้วย';
		pre($_POST);
		exit;
	}
	if (@$_REQUEST['message'] == '') {
		echo '003 กรุณากรอก Message ทดสอบ';
		pre($_POST);
		exit;
	}
	$subject = 'MailTest - ' . $_REQUEST['title'];

	$aMail = array();
	$aMail['title'] = $subject;
	$aMail['content'] = 'Body - ' . $_REQUEST['message'];
	$aMail['emailfrom'] = GlobalConfig_get('smtp_sendername');
	$aMail['emailname'] = GlobalConfig_get('smtp_sendername');
	$aMail['emailfrom_mail'] = GlobalConfig_get('smtp_sender');
	$aMail['emailto'] = $_REQUEST['mailto'];
	pre($aMail);
	$res = Plugin_sendMail($subject, $aMail, true);
	pre($res);
}
