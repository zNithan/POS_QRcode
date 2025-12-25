<?php
/*
 * วิธีเรียกใช้งานที่หน้าเว็บ เพื่อเก็บข้อมูล
 * func_counter_page($pagename='');
 */
global $setcounteroneonly;

function func_counter_set($pagename = '', $IntraInter = 'web')
{
	global $setcounteroneonly;
	if ($setcounteroneonly != '1') {
		func_counter_page($pagename);
		func_counter_txt($pagename, $IntraInter);
	}
	//$setcounteroneonly = 1;
}

function func_counter_page($pagename = '')
{
	$dir = PATH_UPLOAD . '/counter';
	if (!is_dir($dir)) {
		@mkdir($dir, 0777, true);
	}

	if ($pagename === '') {
		$pagename = basename($_SERVER['SCRIPT_NAME']);
	}

	$y = date('Y');
	$m = (int)date('m');

	$file = $dir . "/counter_pages_{$y}.txt";
	$a = [];

	if (file_exists($file)) {
		$content = file_get_contents($file);
		$tmp = json_decode($content, true);
		if (is_array($tmp)) {
			$a = $tmp;
		}
	}

	if (!isset($a[$pagename][$y][$m])) {
		$a[$pagename][$y][$m] = 0;
	}
	$a[$pagename][$y][$m]++;

	$json = json_encode($a); // ไม่ใช้ JSON_PRETTY_PRINT เพื่อลดขนาดไฟล์

	if ($fp = fopen($file, 'w')) {
		if (flock($fp, LOCK_EX)) {
			fwrite($fp, $json);
			flock($fp, LOCK_UN);
		}
		fclose($fp);
	}
}

function func_counter_get($mY = '', $IntraInter = 'web')
{
	global $aReturnGlobal;
	if (isset($aReturnGlobal[$mY . $IntraInter])) {
		return $aReturnGlobal[$mY . $IntraInter];
	}

	$aReturn = array();
	if ($mY == '') {
		$mY = date('m-Y');
		$aReturn['all'] = 0;
		$file = PATH_UPLOAD . '/counter/counter_all.txt';
		$numAll = @file($file);
		$aReturn['year'] = json_decode($numAll[0], true);
		foreach ($aReturn['year'] as $v) {
			$aReturn['all'] = $aReturn['all'] + $v;
		}
	}

	$file = PATH_UPLOAD . '/counter/counter_' . $IntraInter . '_' . $mY . '.txt';
	$num = @file($file);
	$aReturn['month'] = '';
	if (isset($num[0]) && $num[0] != '') {
		$aReturn['month'] = json_decode($num[0], true);
	}

	$aReturnGlobal[$mY] = $aReturn;
	return $aReturn;
}

function func_counter_page_get($year = '')
{
	if (!is_dir(PATH_UPLOAD . '/counter')) {
		@mkdir(PATH_UPLOAD . '/counter', 0777);
	}

	if ($year == '') {
		$year = date('Y');
	}

	$file = PATH_UPLOAD . '/counter/counter_pages_' . $year . '.txt';
	$num = @file($file);
	$a = array();
	if (isset($num[0]) && $num[0] != '') {
		$a = json_decode($num[0], true);
		arsort($a);
	}
	return $a;
}

function func_counter_txt($txtname = '', $IntraInter = 'inter')
{
	global $setCounter;
	if (!is_dir(PATH_UPLOAD)) {
		@mkdir(PATH_UPLOAD, 0777);
	}

	if (!is_dir(PATH_UPLOAD . '/counter')) {
		@mkdir(PATH_UPLOAD . '/counter', 0777);
	}

	/* ==================================================== */
	$y = date('Y');
	$file = PATH_UPLOAD . '/counter/counter_all.txt';
	$num = @file($file);
	if (isset($num[0]) && $num[0] != '') {
		$numAll = json_decode($num[0], true);
	} else {
		$numAll = array();
	}
	/////////////////////////////////////////
	//////////// ป้องกันการทำงานซ้ำ fix use request for one
	if ($setCounter == 1) {
		return $numAll[$y][$IntraInter];
	} else {
		$setCounter = 1;
	}
	/////////////////////////////////////////

	$numYear = (isset($numAll[$y][$IntraInter]) && $numAll[$y][$IntraInter] >= 1) ? $numAll[$y][$IntraInter] + 1 : 1;
	$numAll[$y][$IntraInter] = $numYear;

	$jsonNum = json_encode($numAll);
	$fp = @fopen($file, "w");
	@fputs($fp, $jsonNum);
	@fclose($fp);
	/* ==================================================== */

	$m = date('m-Y');
	$d = date('d');

	$file = PATH_UPLOAD . '/counter/counter_' . $IntraInter . '_' . $m . '.txt';
	$num = @file($file);
	if (isset($num[0]) && $num[0] != '') {
		$num = json_decode($num[0], true);
	}

	if (!is_array($num)) {
		$num = array();
	}

	$num[0] = (isset($num[0]) && $num[0] >= 1) ? $num[0] + 1 : 1;
	$num[$d] = (isset($num[$d]) && $num[$d] >= 1) ? $num[$d] + 1 : 1;

	$jsonNum = json_encode($num);
	$numDay = $num[$d];
	$numMont = $num[0];

	$fp = @fopen($file, "w");
	@fputs($fp, $jsonNum);
	@fclose($fp);
	/* ==================================================== */

	if ($txtname == 'd') {
		return $numDay;
	} elseif ($txtname == 'm') {
		return $numMont;
	} elseif ($txtname == 'y') {
		return $numYear;
	} else {
		$re = 0;
		foreach ($numAll as $v) {
			$re = $re + $v[$IntraInter];
		}
		return $re;
	}
}
