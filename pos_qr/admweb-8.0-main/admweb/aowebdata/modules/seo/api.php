<?php
/*
$keys = 
AddOnScriptBeforCloseHeader
AddOnScriptAfterOpenBody
AddOnScriptBeforCloseBody
*/
function AddOnScript($keys = '')
{
    if ($keys != '') {
        if (file_exists(PATH_UPLOAD . '/config_file/' . $keys . '.html')) {
            include(PATH_UPLOAD . '/config_file/' . $keys . '.html');
        }
    }
}

function SEORedir301()
{
    $chto = DB_GET('site_configs', ['keywords' => 'onoff_redirect_301']);
    if (isset($chto['val']) && $chto['val'] == 'on') {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $row = DB_GET('site_seo_redir', ['source' => $requestUri]);
        if ($row) {

            DB_UP('site_seo_redir', ['hit_count' => ($row['hit_count'] + 1)], ['redir_id' => $row['redir_id']]);
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $row['target']);
            exit();
        }
    }
}
