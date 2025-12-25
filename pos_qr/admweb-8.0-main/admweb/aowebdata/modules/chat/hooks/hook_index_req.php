<?php
function DB_DEL_GROUPCHAT()
{
    $day = GlobalConfig_get('dateGroup', 30);
    $settime = strtotime("-{$day} days");
    $datetime = date('Y-m-d', $settime);
    $sql = "DELETE FROM `" . _DBPREFIX_ . "chat_data_group` WHERE chat_time < '{$datetime}';";
    $db = DB::singleton();
    $db->query($sql, __FUNCTION__);
}
function DB_DEL_USERCHAT()
{
    $day = GlobalConfig_get('dateUser', 30);
    $settime = strtotime("-{$day} days");
    $datetime = date('Y-m-d', $settime);
    $sql = "DELETE FROM `" . _DBPREFIX_ . "chat_data` WHERE chat_time < '{$datetime}';";
    $db = DB::singleton();
    $db->query($sql, __FUNCTION__);
}

DB_DEL_USERCHAT();
DB_DEL_GROUPCHAT();
