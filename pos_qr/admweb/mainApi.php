<?php
header("X-Robots-Tag: noindex, nofollow", true);
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
// header("Content-Security-Policy: default-src 'self'; 
//         script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; 
//         style-src  'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; 
//         font-src   'self' https://fonts.gstatic.com;");
@session_start();

// open all error
error_reporting(E_ALL);
error_reporting(0);

///////////// config /////////////////
include dirname(__FILE__) . '/include/conf.ini.php';
include PATH_PLUGIN . '/db/db.php';
include PATH_PLUGIN . '/config/global.php';
include PATH_PLUGIN . '/mail/function.php';
include PATH_PLUGIN . '/translate/api.php';
include PATH_ADMIN . '/include/function_api.php';
include PATH_ADMIN . '/include/fix.req.php';
include PATH_ADMIN . '/include/func.useronline.php';

///////////// get lang ///////////////
$lang = api_getCurrentLang();

//////////// language ////////////////
foreach ($aConfig['language'] as $k => $v) {
	$languagefile = PATH_AOWEBDATA . '/languages/' . $k . '.php';
	if (is_file($languagefile) && $k != $lang) {
		include $languagefile;
	}
}

$currentlanguagefile = PATH_AOWEBDATA . '/languages/' . $lang . '.php';
if (is_file($currentlanguagefile)) {
	include $currentlanguagefile;
}

if (count($aConfig['aModuleUse']) > 0) {
	foreach ($aConfig['aModuleUse'] as $k => $v) {
		$fmodule = PATH_MODULE . '/' . $v . '/__funcGlobal.php';
		$fcore = PATH_CORE . '/' . $v . '/__funcGlobal.php';
		$aFuncGlobal = is_file($fmodule) ? $fmodule : $fcore;
		if (is_file($aFuncGlobal)) {
			include_once($aFuncGlobal);
		}
	}
}

// load api all module
if (isset($aModuleUse) && count($aModuleUse) > 0) {
	foreach ($aModuleUse as $k => $v) {
		$fmodule = PATH_MODULE . '/' . $v . '/api.php';
		$fcore = PATH_CORE . '/' . $v . '/api.php';
		$modulePath = is_file($fmodule) ? $fmodule : $fcore;
		if (is_file($modulePath) && $v != '') {
			include_once $modulePath;
		}
	}
}
