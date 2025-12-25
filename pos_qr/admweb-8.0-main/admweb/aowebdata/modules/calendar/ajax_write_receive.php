<?php
$name = REQ_get('name', 'post', 'str', '');
$date = REQ_get('date', 'post', 'str', '');
$color = REQ_get('color', 'post', 'str', '');
if ($name !== '' && $date !== '' && $color !== '') {
    $fname = PATH_UPLOAD . '/calendar/date.txt';
    $ck = file_exists($fname) ? read_txt_json($fname) : [];
    $year = explode('-', $date)[0];
    if (!isset($ck[$year][$date])) {
        $ck[$year][$date][$name] = $color;
        write_txt_json($fname, $ck);
    }
}
