<?php
include 'admweb/mainApi.php';
include 'admweb/api/oApi.php';

#SEO REDIRECT 301
SEORedir301();

if (@$_GET['lang'] != '' && in_array($_GET['lang'], array('en', 'th'))) {
	$lang = $_REQUEST['lang'];
	$oApi->setLanguage($lang);
}

define("_LANG_", ($lang) ? $lang : DEFAULT_LANGEUAGE);
////////////////////////////////////////////
///////////// fix test request /////////////
////////////////////////////////////////////

$aosoftwebsiteconfig = [
    'defaultLang' => $lang,
    'supportedLangs' => $langConf, // ถ้าโปรเจ็คไหนมีภาษาเดียวก็เปลี่ยนเป็น ['th'] ได้เลย
    'baseUrl' => '/',
    'pages' => $aConfig['aConfigSitemap']
];

////////////////////////////////////////////

function sharedSocial($url, $type = 'href', $socialname = 'fb')
{
	if ($type == 'href') {
		$u = ($socialname == 'fb')
			? 'https://www.facebook.com/sharer.php?u=' . URL_WEB_ROOT . '/' . $url
			: 'https://twitter.com/intent/tweet?text=' . $url;
	} else {
		$u = "window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;";
	}
	return $u;
}

