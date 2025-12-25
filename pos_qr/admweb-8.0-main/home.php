<?php
if (!defined('ALLOW_DIRECT_ACCESS')) {
    http_response_code(403);
    exit('403 Forbidden');
}

$isLogin = oApi::is_Login();
$isUser = oApi::is_User();
$isAdmin = oApi::is_Admin();

var_dump($isLogin);
echo '<br>';
var_dump($isUser);
echo '<br>';
var_dump($isAdmin);

if ($isAdmin == true) {

}

echo '<br>';
$a = oApi::getLoginData();
pre($a);
echo '<br>';
?>
HOME PAGE