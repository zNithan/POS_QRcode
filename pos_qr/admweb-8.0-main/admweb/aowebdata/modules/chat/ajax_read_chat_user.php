<?php
$user_id = REQ_get('uid', 'requset', 'str', '');
$oid = REQ_get('oid', 'requset', 'str', '');
if (!empty($user_id)) {
    $getallchat = DB_LIST('chat_data', ['user_id_send' => $oid], 0, 1, ' OR user_id_send = ' .  $user_id  . ' ORDER BY chat_time');
    $getuser = DB_GET('member_member', ['user_id' => $user_id]);
}
$getoUser = DB_GET('member_member', ['user_id' => $oid]);
$aPicture = getAdminUserById($getuser['user_id']);
$userPic = Func_Pic_Corp($aPicture['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
$oPic = getAdminUserById($getoUser['user_id']);
$oUserPic = Func_Pic_Corp($oPic['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
foreach ($getallchat['data'] as $v) {
    $time = date('H:i', strtotime($v['chat_time']));
    $time2 = date('Y-m-d H:i', strtotime($v['chat_time']));
    if ($v['user_id_send'] == $user_id && $v['user_id_receive'] == $oid) {
?>
        <div class="row">
            <div class="col-md-6">
                <div class="chat-user">
                    <p class="text-bold" style="text-align: left;"><?php echo  $getuser['firstname'] ?></p>
                    <div class="media-left">
                        <img src="<?php echo $userPic; ?>" class="img-circle img-sm" alt="Profile Picture">
                    </div>
                    <div class="media-body" style="word-break: break-word;">
                        <div>
                            <p class="add-tooltip" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo $time2; ?>"><?php echo $v['message'] ?><small><?php echo $time; ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    if ($v['user_id_send'] == $oid && $v['user_id_receive'] == $user_id) {
    ?>
        <div class=" row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="chat-me">
                    <p class="text-bold" style="text-align: right;"><?php echo $getoUser['firstname'] ?></p>
                    <div class="media-left">
                        <img src="<?php echo $oUserPic; ?>" class="img-circle img-sm" alt="Profile Picture">
                    </div>
                    <div class="media-body" style="word-break: break-word;">
                        <div>
                            <p class="add-tooltip" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $time2; ?>"><?php echo $v['message'] ?><small><?php echo $time; ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>