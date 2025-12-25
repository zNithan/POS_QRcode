<?php
$siteName = $_SERVER['SERVER_NAME'];
$siteName = preg_replace('/^www\./i', '', $siteName);
define("ADMIN_VERSION", '4.8');

if (is_file(dirname(dirname(__FILE__)) . '/aowebdata/fix.' . $siteName . '.php')) {
	include_once(dirname(dirname(__FILE__)) . '/aowebdata/fix.' . $siteName . '.php');
	$con = new mysqli($db_host, $db_user, $db_passwd, $db_name);
	if ($con->connect_errno) {
		$isConnectError = 'Please Check DB USER-PASSWORD';
		include_once(dirname(__FILE__) . '/autoSetup.php');
		echo '<!-- fix.' . $siteName . '.php' . ' -->';
	} else {

		$result = $con->query("SHOW TABLES FROM {$db_name};");
		$row = $result->fetch_all(MYSQLI_NUM);
		$flat = array_column($row, 0);
		$_SESSION['tablerecheck'] = $flat;
		$con->close();
	}
} else {
	$isConnectError = 'File is not Exists';
	include_once(dirname(__FILE__) . '/autoSetup.php');
	echo '<!-- fix.' . $siteName . '.php' . ' -->';
}
