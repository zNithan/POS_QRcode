<?php
$aMemOnline = login_logout::getAllMemberOnline();
$oid = REQ_get('oid', 'requset', 'int', '');
$user_id = REQ_get('uid', 'requset', 'int', '');
$keysname = REQ_get('keysname', 'requset', 'str', '');
$ckGC = REQ_get('ckGC', 'requset', 'str', '');
$ckUC = REQ_get('ckUC', 'requset', 'str', '');
if (!empty($user_id)) {
    DB_UP_USERCHAT($user_id, $oid);
}
$gerUserChat = DB_USER_LIST($oid);
$groupList = DB_GROUP_LIST();
$keysConfig = array_column($_groupConfig, 'keysname');
$keysList = array_column($groupList['data'], 'keysname');
$missKeys = array_diff($keysConfig, $keysList);
foreach ($missKeys as $v) {
    $new = ['keysname' => $v];
    $groupList['data'][] = $new;
}
$getoUser = DB_GET('member_member', ['user_id' => $oid]);
?>
<?php if ($ckGC == 'true') { ?>
    <div class="chat-user-list bord-btm" style="margin-top: 5px;">
        <div class="text-main text-bold text-md" style="margin-left: 5px;">Group</div>
        <?php foreach ($groupList['data'] as $v) {
            if (!isset($_groupConfig[$v['keysname']])) {
                continue;
            }
        ?>
            <a href=<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=chat_board&ct=group_chat&keysname=" . $v['keysname'] . "&otb=Chat%20board|", true); ?> class="chat-unread">
                <div class="media-left">
                    <img class="img-circle img-xs" src="<?php echo $_groupConfig[$v['keysname']]['picture']; ?>" alt="Profile Picture">
                </div>
                <div class="media-body">
                    <span class="chat-info">
                        <?php
                        $time = !empty($v['chat_time']) ? date('Y-m-d H:i', strtotime($v['chat_time'])) : '&nbsp;';
                        ?>
                        <span class="text-xs"><?php echo $time; ?></span>
                    </span>
                    <div class="chat-text">
                        <p class="chat-username"><?php echo $_groupConfig[$v['keysname']]['name']; ?></p>
                        <?php
                        $msg = !empty($v['message']) ? $v['message'] : '&nbsp;';
                        $msg = preg_match('/<img[^>]+>/i', $msg) ? 'ข้อความอีโมติคอน' : str_replace("<br />", " ", $msg);
                        ?>
                        <p><?php echo $msg; ?></p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
<?php } ?>
<?php if ($ckUC == 'true') { ?>
    <div class="chat-user-list" style="margin-top: 5px;">
        <div class="text-main text-bold text-md" style="margin-left: 5px;">User</div>
        <?php
        foreach ($gerUserChat['data'] as $v) {
            $listID = $v['user_id_send'] != $getoUser['user_id'] ? $v['user_id_send'] : $v['user_id_receive'];
            $getDataMember = DB_GET('member_member', ['user_id' => $listID]);
            $getDataOnline = DB_GET('member_online', ['user_id' => $listID]);
            $onlineEndTime = !empty($getDataOnline['onlineEndTime']) ? $getDataOnline['onlineEndTime'] : 0;
            $online = _TIME_ < $onlineEndTime ? 'success' : 'danger';
            $aPicture = getAdminUserById($getDataMember['user_id']);
            $userPic = Func_Pic_Corp($aPicture['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
        ?>
            <a href=<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=chat_board&ct=user_chat&user_id=" . $getDataMember['user_id'] . "&otb=Chat%20board|", true); ?> class="chat-unread">
                <div class="media-left">
                    <img class="img-circle img-xs" src="<?php echo $userPic; ?>" alt="Profile Picture">
                    <i class="badge badge-<?php echo $online; ?> badge-stat badge-icon pull-left"></i>
                </div>
                <div class="media-body">
                    <span class="chat-info">
                        <?php
                        $time = !empty($v['chat_time']) ? date('Y-m-d H:i', strtotime($v['chat_time'])) : '&nbsp;';
                        ?>
                        <span class="text-xs"><?php echo $time ?></span>
                        <?php
                        $notif = DB_UNREAD($getoUser['user_id'], $listID);
                        $unread = $v['user_id_receive'] == $getoUser['user_id'] && $v['read_status'] == 0 ? count($notif['data']) : '';
                        ?>
                        <span class="badge badge-success"><?php echo $unread ?></span>
                    </span>
                    <div class="chat-text">
                        <?php
                        $fullname = $getDataMember['firstname'] . " " . $getDataMember['lastname'];
                        $msg = !empty($v['message']) ? $v['message'] : '&nbsp;';
                        $msg = preg_match('/<img[^>]+>/i', $msg) ? 'ข้อความอีโมติคอน' : str_replace("<br />", " ", $msg);
                        ?>
                        <p class="chat-username"><?php echo $fullname ?></p>
                        <?php $unreadText = $v['user_id_receive'] == $getoUser['user_id'] && $v['read_status'] == 0 ? 'text-bold' : '' ?>
                        <p class="<?php echo $unreadText ?>"><?php echo $msg; ?></p>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
<?php } ?>