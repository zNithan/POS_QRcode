<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp|keysname', 'สามารถเปิด Banner Management ได้', 'redirect', 'SET');
$lang 	  = getCurrentLang();
$mp 	  = REQ_get('mp', 'request', 'str', '');
$idclub   = REQ_get('idclub', 'request', 'int', '');
$module   = REQ_get('module', 'request', 'str', '');
$inc 	  = REQ_get('inc', 'request', 'str', 'banner');
$keysname = REQ_get('keysname', 'request', 'str', '');
define("PLUGIN_INC", 'banner');

/////////////////////////////////////////////////////////////////////
//////////////////////////// IS OPEN //////////////////////////////
/////////////////////////////////////////////////////////////////////
$isOpens = array();
$aBannerConfig 	= array();
$tagname = array();

/* =========================== */
$isOpens['isTitle'] 	= true;
$isOpens['isDetail'] 	= true;
$isOpens['isLink'] 		= true;
$isOpens['extra1'] 		= true;
$isOpens['extra2'] 		= true;

$aBannerConfig['title'] 	=  'Banner Management';
$aBannerConfig['titlesort']	= 'Sort Banner';
$aBannerConfig['height'] 	= '172';
$aBannerConfig['width'] 	= '1003';
/* =========================== */

/////////////////////////////////////////////////////////////////
//////////////////////// ARTICLE FUNCIG /////////////////////////
/////////////////////////////////////////////////////////////////
$aBannerConfig['path']	= 'banner';
$aBannerConfig['icontype'] = array('jpg', 'gif', 'png');
$aBannerConfig['iconNotics'] = array(
	'Dimensions, widths, desired images ' . $aBannerConfig['width'] . 'px Suitable height ' . $aBannerConfig['height'] . 'px',
	'The file extension that can be uploaded is' . implode(' , ', $aBannerConfig['icontype']),
	'Please complete the details. For the benefit of the search website, allowing you to rank well on the search website',
);

////////////////////////////////////////////////////////////////////
////////////////////////// INC PLUGIN /////////////////////////////
//////////////////////////////////////////////////////////////////
if (is_file(PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php')) {
	include(PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php');
} else {
	echo '<div style="padding:20px;"> Cannon get Function. ( ' . PATH_PLUGIN . '/' . PLUGIN_INC . '/function.php )</div> ';
}

if (is_file(PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php')) {
	include(PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php');
} else {
	echo '<div style="padding:20px;"> INC page is fail. ( ' . PATH_PLUGIN . '/' . PLUGIN_INC . '/inc_' . $inc . '.php )</div>';
}
