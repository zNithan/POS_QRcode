<?php
include 'inc.php';
define('ALLOW_DIRECT_ACCESS', true);

$_getdata = [];
$pagesDir = __DIR__ . '/';
$defaultLang = $lang;
$supportedLangs = ['th', 'en'];

// ดึง path จาก URL
// 1. ดึง URI มา เช่น /en/article/how-to-grow?foo=bar
$uri = $_SERVER['REQUEST_URI'];

// 2. ตัด query string ทิ้ง (ถ้ามี)
$uri = parse_url($uri, PHP_URL_PATH);

// 3. ตัด / ออกข้างหน้าและข้างหลัง
$route = trim($uri, '/');

// 4. ล้างค่า เพื่อความปลอดภัย
$route = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $route);

// 5. แยกเป็น array
$parts = explode('/', $route);

//เพิ่มจุดนี้: ป้องกัน path traversal เช่น /../../config
foreach ($parts as $part) {
    if (strpos($part, '..') !== false) {
        http_response_code(400);
        exit('400 Bad Request');
    }
}

// 6. ตรวจสอบภาษา
$lang = $defaultLang;
if (in_array($parts[0], $supportedLangs)) {
    $lang = array_shift($parts);
}

// 7. Routing Logic
if (empty($route) || $route === '' || (count($parts) === 1 && $parts[0] === '')) {
    MemberOnline('home.php');
    include $pagesDir . 'home.php';
    exit;
}

if (!empty($parts[0]) && in_array($parts[0], $aosoftwebsiteconfig['pages'], true) || isset($aosoftwebsiteconfig['pages'][$parts[0]])) {
    $filename = basename($parts[0]);
    $file = rtrim($pagesDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename . '.php';
    $realPagesDir = realpath($pagesDir);
    $realFilePath = realpath($file);
    if ($realFilePath && strpos($realFilePath, $realPagesDir) === 0 && file_exists($realFilePath)) {
        if (isset($parts[1]) && $parts[1] !== '' && ctype_digit($parts[1])) {
            $_getdata['id'] = $parts[1];
        } else {
            $_getdata['slug'] = $parts[1];
        }

        $_getdata['key2'] = $parts[2] ?? '';
        $_getdata['key3'] = $parts[3] ?? '';
        $_getdata['lang'] = $lang ?? DEFAULT_LANGEUAGE;

        MemberOnline($filename . '.php');
        include $realFilePath;
        exit;
    }
} else {
    if ($_SERVER['REQUEST_URI'] == '/index.php') {
        MemberOnline('home.php');
        include $pagesDir . 'home.php';
        exit;
    }
}

http_response_code(403);
exit('403 Forbidden');