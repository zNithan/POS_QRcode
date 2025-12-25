<?php
include 'config.php';

function DB_USER_LIST($id, $num = 0, $page = 0)
{
    $sql = "
	SELECT user_id_send, user_id_receive, message, chat_time, read_status
    FROM ao_chat_data
    WHERE (user_id_send = {$id} OR user_id_receive = {$id}) 
    AND chat_time IN (
    SELECT MAX(chat_time)
    FROM ao_chat_data
    WHERE user_id_send = {$id} OR user_id_receive = {$id}
    GROUP BY LEAST(user_id_send, user_id_receive), GREATEST(user_id_send, user_id_receive)
    )
    GROUP BY chat_time
    ORDER BY chat_time DESC
	";
    $db = DB::singleton();
    $a = $db->pager(__FUNCTION__, $sql, $num, $page);
    return $a;
}

function DB_USER_GET_MAX($id)
{
    $sql = "
    SELECT *
    FROM `ao_chat_data` 
    WHERE user_id_send = {$id} OR user_id_receive = {$id}
    ORDER BY chat_time DESC
    LIMIT 1;
    ";
    $db = DB::singleton();
    $db->query($sql, __FUNCTION__);
    $db->next_record();
    $a = ($db->num_rows() > 0) ? $db->allRows() : array();
    return $a;
}

function DB_GROUP_LIST($num = 0, $page = 0)
{
    $sql = "
	SELECT *
    FROM (SELECT * FROM `ao_chat_data_group` ORDER BY chat_time DESC) As chatList
    GROUP BY keysname
    ORDER BY chat_time DESC
	";
    $db = DB::singleton();
    $a = $db->pager(__FUNCTION__, $sql, $num, $page);
    return $a;
}

function DB_UP_USERCHAT($id_send, $id_receive)
{
    $sql = "UPDATE " . _DBPREFIX_ . "chat_data SET read_status = '1' WHERE user_id_send = {$id_send} AND user_id_receive = {$id_receive}";
    $db = DB::singleton();
    $db->query($sql, __FUNCTION__);
}

function DB_NOTIF_LIST($id, $num = 0, $page = 0)
{
    $sql = "
    SELECT * 
    FROM (
    SELECT * 
    FROM " . _DBPREFIX_ . "chat_data 
    WHERE user_id_receive = {$id} AND read_status = 0 
    ORDER BY chat_time DESC
    ) AS u LEFT JOIN " . _DBPREFIX_ . "member_member m ON u.user_id_send = m.user_id
    GROUP BY user_id_send
    ";
    $db = DB::singleton();
    $a = $db->pager(__FUNCTION__, $sql, $num, $page);
    return $a;
}

function DB_UNREAD($oid, $id, $num = 0, $page = 0)
{
    $sql = "
    SELECT * 
    FROM `ao_chat_data` 
    WHERE (user_id_send = {$id} AND user_id_receive = {$oid}) 
    AND read_status = 0
    ";
    $db = DB::singleton();
    $a = $db->pager(__FUNCTION__, $sql, $num, $page);
    return $a;
}

function getSearchMember($id, $keysword = '', $num = 20, $page = 0)
{
    $sql = "
	SELECT u.* , m.*
	FROM " . _DBPREFIX_ . "member_user u
    LEFT JOIN " . _DBPREFIX_ . "member_member m ON m.user_id = u.user_id
    WHERE u.user_id IS NOT NULL
    AND u.user_id != {$id}
	AND (
		m.user_id LIKE '{$keysword}%'
		OR m.firstname LIKE '{$keysword}%'
		OR m.lastname LIKE '%{$keysword}%'
		OR m.email LIKE '%{$keysword}%'
	    )
	ORDER BY u.user_id
	";
    $db = DB::singleton();
    $aData = $db->pager(__FUNCTION__, $sql, $num, $page);
    return $aData;
}
function checkpermitchat($ckGC, $ckUC, $keysname, $id, $ct)
{
    if ($ct === '') {
        if ($ckGC) {
            CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ct=group_chat&keysname=" . $keysname);
            exit;
        } elseif ($ckUC) {
            CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ct=user_chat&user_id=" . $id);
            exit;
        }
    }
    if (!$ckGC && !$ckUC) {
        setRaiseMsg('You not have permission access.', _TIME_, 1);
        CustomRedirectToUrl('index.php', true);
        exit;
    }
}
