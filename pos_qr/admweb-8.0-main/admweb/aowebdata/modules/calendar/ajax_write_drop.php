<?php
$name = REQ_get('name', 'post', 'str', '');
$date = REQ_get('date', 'post', 'str', '');
$color = REQ_get('color', 'post', 'str', '');
$old = REQ_get('old', 'post', 'str', '');
if ($name !== '' && $date !== '' && $color !== '' && $old !== '') {
    $fname = PATH_UPLOAD . '/calendar/date.txt';
    if (file_exists($fname)) {
        $ck = read_txt_json($fname);
        $year = explode('-', $old)[0];
        if (isset($ck[$year][$old])) {
            unset($ck[$year][$old]);
            if (empty($ck[$year])) {
                unset($ck[$year]);
            }
        }
        $year = explode('-', $date)[0];
        if (!isset($ck[$year][$date])) {
            $ck[$year][$date][$name] = $color;
        }
        write_txt_json($fname, $ck);
    }
}
