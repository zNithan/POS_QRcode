<?php
function checkTodayIntro()
{
    $fdate = PATH_UPLOAD . '/calendar/date.txt';
    $fevent = PATH_UPLOAD . '/calendar/event.txt';
    if (!file_exists($fdate) || !file_exists($fevent)) {
        return '';
    }
    $date = read_txt_json_event($fdate);
    $event = read_txt_json_event($fevent);
    $year = date('Y', _TIME_);
    $today = date('Y-m-d', _TIME_);
    if (!isset($date[$year][$today])) {
        return '';
    }
    $html = key($date[$year][$today]);
    if (isset($event[$html])) {
        $intro = key($event[$html]);
        return $intro;
    }
    return '';
}

function getFestivalIntro()
{
    $today = checkTodayIntro();
    if ($today == "") {
        header("Location: home.html");
        exit();
    } else {
        include("intro/" . $today);
    }
}

function read_txt_json_event($fname)
{
    $data = @file($fname);
    if (isset($data[0])) {
        $data = json_decode($data[0], true);
    } else {
        $data = [];
    }
    return $data;
}
