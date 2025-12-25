<?php
include 'admweb/mainApi.php';
include 'admweb/api/oApi.php';

$oUser = oApi::getLoginData();


if (@$_GET['lang'] != '' && in_array($_GET['lang'], array('en', 'th'))) {
	$lang = $_REQUEST['lang'];
	$oApi->setLanguage($lang);
}


function getcustomer($num=0, $page=1)
{
	/*
	$sql = "SELECT *
			FROM "._DBPREFIX_."site_articles_file
			WHERE articles_id = '{$id}'
			ORDER BY ctime ASC
			";
			$db = DB::singleton();
			$aData = $db->pager(__FUNCTION__, $sql, $num, $page);
		
	return $aData;
	*/
}
