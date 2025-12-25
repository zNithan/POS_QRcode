<?php
date_default_timezone_set("Asia/Bangkok");
setlocale(LC_ALL, 'en_EN.UTF8');

# database setting
$db_host         = 'localhost';
$db_name         = 'websiam_adminVersion8';
$db_user         = 'root';
$db_passwd         = '123';

# ให้กำหนดเป็น on เมื่อติดตั้ง admweb แล้วหากยังไม่ได้ติดตั้งต้องกำหนด off เท่านั้น
define("_IS_COOKIE_LOGIN_TIME_", 'off');
define("DATABASE_INC", 'php_v8'); // ใช้ได้เฉพาะ (php_v8, php_v7)

// ถ้าติดตั้งไม่ได้ให้ลด MEMORY_COST ลง
define("MEMORY_COST", 1 << 17);
define("TIME_COST", 4);
define("THREADS", 1);

define("_HTTPSREQ_", false);
define("DATABASE_TYPE", 'mysqli');
define("_DBPREFIX_", 'ao_');
define("OPEN_ERROR_REPORT", true);
define("OPEN_HELP_API", false);
define("DISPLAY_MAX_UPLOAD", true);
define("ADMIN_PRO_TITLE_MAIN", 'AOSOFT');
define("PRONAME", 'AOSOFT');
define("ADMIN_TITLE", 'ADMIN AOSOFT WEB');
define("ADMIN_FOOTER_TITLE", '© webapp.com');
define("ADMIN_INSTALL_PASSWORD", "ao123456");
define("ADMIN_EMAIL", "webapp.com");

# Mail setting
define("MAIL_SMTP_HOST", "webapp.com");
define("MAIL_SMTP_PORT", "25");
define("MAIL_SMTP_USER", "");
define("MAIL_SMTP_PASS", "");

define("ONLINE_MINUTE", 10);
define("DASHBOARD_NAME", 'main_v1');

# web setting
$webUrl = '//' . $_SERVER['HTTP_HOST'];
$webPath = (@$webPath != '') ? $webPath : dirname(dirname(dirname(__FILE__)));

$aModuleUse = array(
    'ir',
    'menu',
    'search',
    'counter',
    'dashboard',
    'member',
    'billing',
    'chat',
    'calendar',
    'sitemap',
    'example',
    'html',
    'seo',
    'translate',
    'siteconfig',
);

$aConfig['language'] = array(
    'th' => 'Thai',
    'en' => 'English',
);

/* #####################Sitemap###########################
    $aConfigSitemap ระบุหน้าทั่วไปแต่ละหน้าฝั่ง FrontEnd
    ถ้าหน้าไหนมี slug ต่อหลังให้สร้าง value เป็น array
    พร้อมระบุ Keysname ที่ต้องใช้ query ในหน้านั้น

    changefreq คือความถี่ในการเปลี่ยนแปลงข้อมูลของหน้านั้น ได้แก่:
    - always: เปลี่ยนตลอดเวลา (หน้าแรก, Feed ข่าว)
    - hourly: ทุกชั่วโมง (พยากรณ์อากาศ, หุ้น)
    - daily: ทุกวัน (หน้าข่าวหน้าหลัก)
    - weekly: ทุกสัปดาห์ (บทความทั่วไป, หน้าสินค้า)
    - monthly: ทุกเดือน (หน้าบริการ, FAQ)
    - yearly: ทุกปี (หน้าเกี่ยวกับเรา, นโยบาย)
    - never: ไม่เคยเปลี่ยน (หน้า Archive เก่าๆ)

    priority คือลำดับความสำคัญของหน้านั้น (ค่าระหว่าง 0.0 - 1.0) ได้แก่:
    - 1.0: หน้าหลักของเว็บไซต์ (Homepage)
    - 0.8 - 0.9: หน้าหมวดหมู่หลัก หรือหน้าบทความยอดนิยม
    - 0.5 - 0.7: หน้าบทความทั่วไป หรือหน้าบริการ
    - 0.1 - 0.4: หน้าข้อมูลรอง เช่น นโยบายความเป็นส่วนตัว หรือหน้าติดต่อเรา
*/  ######################################################
$aConfig['aConfigSitemap'] = [
    'aboutus',
    'contactus',
    'news' => ['keysname' => 'news', 'changefreq' => 'weekly', 'priority' => '0.8'],
    'products' => ['keysname' => 'products', 'changefreq' => 'daily', 'priority' => '0.9'],
];

define("TELEGRAM_TOKEN", '7903800548:AAFGGbFnTxBprIA5SSngcQVsvdd-dIZ7MuU');
define("WEBSITE_NAME_SEO", 'STU FOR TEST');
define("DOMAIN_NAME", 'webapp.com');
define("PATH_WEB_ROOT", $webPath);
define("URL_WEB_ROOT", $webUrl);

define("PATH_ADMIN", PATH_WEB_ROOT . '/admweb');
define("URL_ADMIN", URL_WEB_ROOT . '/admweb');

define("PATH_AOWEBDATA", PATH_ADMIN . '/aowebdata');
define("URL_AOWEBDATA", URL_ADMIN . '/aowebdata');

# upload setting
define("PATH_UPLOAD", PATH_WEB_ROOT . '/uploads');
define("URL_UPLOAD", URL_WEB_ROOT . '/uploads');

# Html Template
define("PATH_UPLOAD_HTML", PATH_UPLOAD . '/_temp');
define("URL_UPLOAD_HTML", URL_UPLOAD . '/_temp');

# Config
define("PATH_UPLOAD_CONFIG", PATH_UPLOAD . '/config');
define("URL_UPLOAD_CONFIG", URL_UPLOAD . '/config');

# Admin Module
define("PATH_CORE", PATH_ADMIN . '/core');
define("URL_CORE", URL_ADMIN . '/core');

# Admin Custom Module
define("PATH_MODULE", PATH_AOWEBDATA . '/modules');
define("URL_MODULE", URL_AOWEBDATA . '/modules');

# Plugin
define("PATH_PLUGIN", PATH_ADMIN . '/plugins');
define("URL_PLUGIN", URL_ADMIN . '/plugins');

# Help
define("PATH_HELP", PATH_ADMIN . '/help');
define("URL_HELP", URL_ADMIN . '/help');

define("TEMPLATE_NAME", 'version2018');
define("CACHE_VERSION", '2018');
define("THEMENAME", 'custom1');

define("TEMPLATE_PATH", PATH_ADMIN . '/template/' . TEMPLATE_NAME);
define("TEMPLATE_URL", URL_ADMIN . '/template/' . TEMPLATE_NAME);

$aFileAllow = array(
    'image/jpeg',
    'image/gif',
    'image/pjpeg',
    'image/x-png ',
);

$allowExtention = array(
    'jpg',
    'gif',
    'png',
);

define("IS_SHOW_SEARCH", false);
define("IS_NAME_SEARCH", 'ค้นหาข้อมูล'); //input name is fix qsearch
define("IS_LINK_SEARCH", URL_ADMIN . '/index.php?module=search&mp=search&ac=search');

define("DEBUG_VIEW", true);
define("DEBUG_SQL", (DOMAIN_NAME == 'localhost') ? true : false);
define("ERROR_REPORT_ALL", "0");
define("CHARSET", "utf-8"); //utf-8, windows-874
define("IS_SHOW_UPLOAD_SIZE", false);
define("IS_SHOW_HELP", true);
define("IS_FORGOT_PASS", false);
define("IS_LOGIN_PROVIDER", true);
define("IS_MATA_REDIRECT", false);
define("DEFAULT_LANGEUAGE", "th");
define("ENCODE_PASSWORD_MEMBER", true);
define("PW_RESET", "1a2b3c");
define("_TIME_", time());
define("_YY_", date('Y'));
define("_MM_", date('m'));
define("_DD_", date('d'));

$aMemberNameDisable = array(
    'admin',
    'member'
);

$aConfig['aModuleUse']      = $aModuleUse;
$aConfig['aUserDisable']    = $aMemberNameDisable;
$aConfig['codeBlock']       = 'true';
$aConfig['insertHTML']      = 'true';
$aConfigSitemap             = $aConfig['aConfigSitemap'];

include_once(PATH_ADMIN . '/include/a.province.php');
include_once(PATH_ADMIN . '/include/a.months.php');
