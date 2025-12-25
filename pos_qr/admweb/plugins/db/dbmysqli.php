<?php

define("DB_HOST", "$db_host");
define("DB_NAME", "$db_name");
define("DB_USER", "$db_user");
define("DB_PWD", "$db_passwd");

$_SESSION['logs_sql'] = array();
include 'function/php_v8.php';
include 'function/func_v8.php';
$db = &DB::singleton();
