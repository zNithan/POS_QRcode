<?php
if (_AC_ == 'add2') {
    $oid = REQ_get('oid', 'requset', 'int', '');
    $msg = REQ_get('msg', 'requset', 'str', '');
    $msg = ($msg === null || $msg === '') ? $_POST['msg'] : nl2br(htmlspecialchars($msg));
    $keysname = REQ_get('keysname', 'requset', 'str', '');
    $datetime = date('Y-m-d H:i:s');
    $a = [];
    //$a['chat_id'] = NULL;
    $a['user_id_send'] = $oid;
    $a['message'] = $msg;
    $a['chat_time'] = $datetime;
    $a['keysname'] = $keysname;
    DB_ADD('chat_data_group', $a);
}
