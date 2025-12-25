<?php
function updateYear()
{
    $fname = PATH_UPLOAD . '/calendar/date.txt';
    if (file_exists($fname)) {
        $date = read_txt_json($fname);
        $currentYear = date('Y', _TIME_);
        foreach (range($currentYear - 2, $currentYear - 3) as $v) {
            if (isset($date[$v])) {
                unset($date[$v]);
            }
        }
        if (empty($date)) {
            unlink($fname);
        } else {
            write_txt_json($fname, $date);
        }
    }
}

function delEvent($name)
{
    $fevent = PATH_UPLOAD . '/calendar/event.txt';
    $fdate = PATH_UPLOAD . '/calendar/date.txt';
    if (file_exists($fevent) && $name !== '') {
        $ckEvent = read_txt_json($fevent);
        if (isset($ckEvent[$name])) {
            unset($ckEvent[$name]);
            if (file_exists($fdate)) {
                $ckDate = read_txt_json($fdate);
                $date = delDateEvent($ckDate, $name);
                if (!empty($date)) {
                    write_txt_json($fdate, $date);
                } else {
                    unlink($fdate);
                }
            }
            if (!empty($ckEvent)) {
                write_txt_json($fevent, $ckEvent);
            } else {
                unlink($fevent);
            }
        }
    }
}

function delDateEvent($data, $name)
{
    foreach ($data as $year => $dates) {
        foreach ($dates as $date => $event) {
            if (isset($event[$name])) {
                unset($data[$year][$date]);
            }
        }
        if (empty($data[$year])) {
            unset($data[$year]);
        }
    }
    return $data;
}
