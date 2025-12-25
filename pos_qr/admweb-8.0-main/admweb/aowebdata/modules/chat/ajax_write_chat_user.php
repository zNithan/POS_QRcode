<?php
if (_AC_ == 'add') {
    $user_id = REQ_get('uid', 'requset', 'int', '');
    $oid = REQ_get('oid', 'requset', 'int', '');
    $msg = REQ_get('msg', 'requset', 'str', '');
    $msg = ($msg === null || $msg === '') ? $_POST['msg'] : nl2br(htmlspecialchars($msg));
    $datetime = date('Y-m-d H:i:s');
    $a = [];
    //$a['chat_id'] = NULL;
    $a['user_id_send'] = $oid;
    $a['user_id_receive'] = $user_id;
    $a['message'] = $msg;
    $a['chat_time'] = $datetime;
    $a['read_status'] = '0';
    DB_ADD('chat_data', $a);
}
