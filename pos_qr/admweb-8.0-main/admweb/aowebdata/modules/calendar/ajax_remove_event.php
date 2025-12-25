<?php
$date = REQ_get('date', 'post', 'str', '');
if ($date !== '') {
    $fname = PATH_UPLOAD . '/calendar/date.txt';
    if (file_exists($fname)) {
        $ck = read_txt_json($fname);
        $year = explode('-', $date)[0];
        if (isset($ck[$year][$date])) {
            unset($ck[$year][$date]);
            if (empty($ck[$year])) {
                unset($ck[$year]);
            }
            if (!empty($ck)) {
                write_txt_json($fname, $ck);
            } else {
                unlink($fname);
            }
        }
    }
}
