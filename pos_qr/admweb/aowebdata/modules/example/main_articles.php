<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp|keysname', 'สามารถเปิด Articles ได้', 'redirect', 'SET');
$inc      = REQ_get('inc', 'request', 'str', 'list');
$lang     = getCurrentLang();
$mp       = REQ_get('mp', 'request', 'str', '');
$module   = REQ_get('module', 'request', 'str', '');
$keysname = REQ_get('keysname', 'request', 'str', '');
define("PLUGIN_INC", 'articles');

/////////////////////////////////////////////////////////////////////
//////////////////////////// IS OPEN //////////////////////////////
/////////////////////////////////////////////////////////////////////
$isOpens = array();
$aArticleConfig = array();
$rep = false;
$isAttch = false;
if (is_file(PATH_PLUGIN . '/' . PLUGIN_INC . '/config.php')) {
	include(PATH_PLUGIN . '/' . PLUGIN_INC . '/config.php');
}

////////////////////////////////////////////////////////////////////////
/////////////////////////// IS OPEN DEFAULT  ///////////////////////////
//////////////////////////////////////////////////////////////////////// 
$w = 287;
$h = 135;
$w2 = 287;
$h2 = 135;
OPT_CONF('isOnOff', 'DISPLAY', true);
OPT_CONF('isTitle', 'ขื่อสินค้า', true);
OPT_CONF('isShortMessage', 'Short Message test', true);
OPT_CONF('isIcon', 'Picture icon', true);
OPT_CONF('isIcon2', 'Picture icon2', true);

OPT_CONF('isExtra1', 'exname 1', true, 'ex1');
OPT_CONF('isExtra2', 'exname 2', true, 'ex2');
OPT_CONF('isExtra3', 'exname 3', true, 'ex3');
OPT_CONF('isExtra4', 'exname 4', true, 'ex4');
OPT_CONF('isExtra5', 'exname 5', true, 'ex5');
OPT_CONF('isExtra6', 'exname 6', true, 'ex6');
OPT_CONF('isExtra7', 'exname 7', true, 'ex7');
OPT_CONF('isExtra8', 'exname 8', true, 'ex8');
OPT_CONF('isExtra9', 'exname 9', true, 'ex9');
OPT_CONF('isExtra10', 'exname 10', true, 'ex10');


////================TAO TEST==================////
OPT_CONF('isContentExtra1', 'รายละเอียด 1', true);
OPT_CONF('isContentExtra2', 'รายละเอียด 2', true);
OPT_CONF('isContentExtra3', 'รายละเอียด 3', true);
OPT_CONF('isAuthor', 'ชื่อผู้เขียน', true);
OPT_CONF('isContent', 'รายละเอียดเนื้อหา Content', true);
OPT_CONF('isContent2', 'รายละเอียดเนื้อหา content2', true);
OPT_CONF('isContent3', 'รายละเอียดเนื้อหา content3', true);
OPT_CONF('isContent4', 'รายละเอียดเนื้อหา content4', true);
OPT_CONF('isDisplaydate', 'Start Date', true);
OPT_CONF('isKeyswords', 'คีย์เวิร์ด', true);
OPT_CONF('isTypes', 'เลือกประเภท Type', true);
OPT_CONF('isContentAttach', 'Attach ไฟล์ในแต่ละภาษา', true);
OPT_CONF('isIconGroup', 'อัพโหลดรูปไอคอนของหมวด', true);
OPT_CONF('isIconGroup2', 'อัพโหลดรูปไอคอนของหมวด2', true);
OPT_CONF('isContent_icon', 'ICON แต่ละภาษา', true);
OPT_CONF('isExtraOption', 'จัดการให้สิทธ์', true);
OPT_CONF('isExtraOption', 'จัดการให้สิทธ์', true);
OPT_CONF('isOpenGroup', 'เลือกหมวด', true);
OPT_CONF('isTypeName', 'Please Select Zone', true);
OPT_CONF('isSlug', 'URL Name', true);
////================TAO TEST / No Tagname==================////
OPT_CONF('isAttach', 'Attach', true); //
OPT_CONF('isAttachFile', 'AttachFile', true); //
OPT_CONF('isAttachPic', 'AttachPic', true); //

OPT_CONF('isSeoArticleList', 'SeoArticleList', true); //
OPT_CONF('isCheckedOption', 'CheckedOption', true); //
OPT_CONF('isCheckedOption', 'CheckedOption', true); //
OPT_CONF('isEndDate', 'EndDate', true); //

OPT_CONF('isIconType', 'IconType', true); //

OPT_CONF('isGroupDetail', 'GroupDetail', true); //
OPT_CONF('isGroupDetailExtra1', 'GroupDetailExtra1', true); //
OPT_CONF('isGroupDetailExtra2', 'GroupDetailExtra2', true); //
OPT_CONF('isGroupName', 'GroupName', true); //
OPT_CONF('isGroupExtra1', 'GroupExtra1', true); //
OPT_CONF('isGroupExtra2', 'GroupExtra2', true); //
OPT_CONF('isGroupExtra3', 'GroupExtra3', true); //
OPT_CONF('isGroupExtra4', 'GroupExtra4', true); //
OPT_CONF('isGroupExtra5', 'GroupExtra5', true); //
OPT_CONF('isSeoGroupInner', 'SeoGroupInner', false); //
OPT_CONF('isGroupAttachPic', 'isGroupAttachPic', true);
OPT_CONF('isGroupSlug', 'URL Name', true); //
OPT_CONF('isTags', 'Tags', true); //
OPT_CONF('isMark', 'Mark', true); //error

OPT_CONF('EDTNAME', 'ckeditor', GlobalConfig_get('editortype', 'ckeditor')); //ใช้แบบนี้



$tagname['titledes'] = ' Test titledes';

//$isOpens['isOnOff']          = true;
//$isOpens['isTitle']          = true;

//$isOpens['isTitle']          = true;
//$tagname['name'] = 'Title';


//$tagname['title'] 		    = 'Title';

$tagname['icon'] 		    = 'Icon';
$tagname['name'] 		    = 'Example';
$tagname['typetitle']    	= 'Option';
$tagname['icon_TipSize']	= 'Picture Width ';
$tagname['icon_TipType']	= 'File Extension ';

$aArticleConfig['attach'] 	= array('jpg', 'gif', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
$aArticleConfig['icon']		= array('jpg', 'gif', 'png');                  //'jpg','gif','pdf','doc','docx','ppt', 'xls'
$aArticleConfig['editorheight'] = '300';
$aArticleConfig['is_group'] 		  = 'y';


@$aArticleConfig['widthIcon'] 			    = $w;
@$aArticleConfig['widthIcon_notics'] = $w . 'px × ' . $h . 'px';
@$aArticleConfig['widthIcon_notics2'] = $w2 . 'px × ' . $h2 . 'px';

$aArticleConfig['iconNotics'] = array(
	'Dimensions, widths, desired images ' . $aArticleConfig['widthIcon'] . 'px',
	'The file extension that can be uploaded is ' . implode(' , ', $aArticleConfig['icon']),
);

$aArticleConfig['attachNotics'] = array(
	'The file extension that can be uploaded is ' . implode(' , ', $aArticleConfig['attach']),
);

if ($inc == 'list') {
	$aArticleConfig['articles_url']		= $keysname . '-inner.php?keysname=' . $keysname . '&id=';
} else if ($inc == 'pages') {
	$aArticleConfig['articles_url']		= $keysname . '-inner.php?keysname=' . $keysname . '&id=';
} else if (in_array($mp, array('banner', 'config', 'html'))) {
	$aArticleConfig['articles_url']		= 'index.php';
} else {
	$aArticleConfig['articles_url']		= 'articles-inner.php?keysname=' . $keysname . '&id=';
}
$imgsize = '740px × 400px';
/* =========================== */
/////////////////////////////////////////////////////////////////////
////////////////////////// INC PLUGIN /////////////////////////////
/////////////////////////////////////////////////////////////////////
if (is_file(PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php')) {
	include(PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php');
} else {
	echo '<li> Cannon get Function. ( ' . PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php )</li> ';
}

if (is_file(PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php')) {
	include(PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php');
} else {
	echo '<li> INC page is fail. ( ' . PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php )</li>';
}
