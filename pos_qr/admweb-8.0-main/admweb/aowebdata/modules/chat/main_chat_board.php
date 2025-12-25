<?php
$ckGC = PERMIT::_PERMIT(_MODULE_, 'You can open group chat', 'สามารถเปิด Group Chat ได้', 'return', 'SET');
$ckUC = PERMIT::_PERMIT(_MODULE_, 'You can open user chat', 'สามารถเปิด User Chat ได้', 'return');
$oUser = login_logout::getLoginData();
$ct = REQ_get('ct', 'requset', 'str', '');
$uid = REQ_get('user_id', 'requset', 'int');
$keysname = REQ_get('keysname', 'requset', 'str', 'group1');
$oid = $oUser->user_id;
$ckLUM = DB_USER_GET_MAX($oid);
if (count($ckLUM) > 0) {
    $ckLUM = $ckLUM['user_id_send'] !== $oid ? $ckLUM['user_id_send'] : $ckLUM['user_id_receive'];
} else {
    $ckLUM = "";
}
checkpermitchat($ckGC, $ckUC, $keysname, $ckLUM, $ct);
if (!empty($uid)) {
    $getallchat = DB_LIST('chat_data', ['user_id_send' => $oid], 0, 1, ' OR user_id_send = ' .  $uid  . ' ORDER BY chat_time');
    $getuser = DB_GET('member_member', ['user_id' => $uid]);
}
$groupList = DB_GROUP_LIST();
$keysConfig = array_column($_groupConfig, 'keysname');
$keysList = array_column($groupList['data'], 'keysname');
$missKeys = array_diff($keysConfig, $keysList);
foreach ($missKeys as $v) {
    $new = ['keysname' => $v];
    $groupList['data'][] = $new;
}
$gerUserChat = DB_USER_LIST($oid);
$getallchatgroup = DB_LIST('chat_data_group', ['keysname' => $keysname], 0, 1, ' ORDER BY chat_time');
$getoUser = DB_GET('member_member', ['user_id' =>  $oid]);
$oUserPic = Func_Pic_Corp($oUser->picture, TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
$themeColor = GlobalConfig_get('cssfulltheme') ? '#434c5c' : '#D6DBE0';
?>
<div class="page-fixedbar-container">
    <div class="page-fixedbar-content">
        <div class="nano has-scrollbar" style="margin-top: 15px;">
            <div class="nano-content" tabindex="0" style="right: -17px;" id="chat-data-list">
                <?php if ($ckGC) { ?>
                    <div class="chat-user-list bord-btm" style="margin-top: 5px;">
                        <div class="text-main text-bold text-md" style="margin-left: 5px;">Group</div>
                        <?php foreach ($groupList['data'] as $v) {
                            if (!isset($_groupConfig[$v['keysname']])) {
                                continue;
                            }
                        ?>
                            <a href=<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ct=group_chat&keysname=" . $v['keysname'] . "&otb=Chat%20board|", true); ?> class="chat-unread">
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
                <?php if ($ckUC) { ?>
                    <div class="chat-user-list" style="margin-top: 5px;">
                        <div class="text-main text-bold text-md" style="margin-left: 5px;">User</div>
                        <?php
                        foreach ($gerUserChat['data'] as $v) {
                            $listID = $v['user_id_send'] != $oid ? $v['user_id_send'] : $v['user_id_receive'];
                            $getDataMember = DB_GET('member_member', ['user_id' => $listID]);
                            $getDataOnline = DB_GET('member_online', ['user_id' => $listID]);
                            $onlineEndTime = !empty($getDataOnline['onlineEndTime']) ? $getDataOnline['onlineEndTime'] : 0;
                            $online = _TIME_ < $onlineEndTime ? 'success' : 'danger';
                            $aPicture = getAdminUserById($getDataMember['user_id']);
                            $userPic = Func_Pic_Corp($aPicture['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
                        ?>
                            <a href=<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ct=user_chat&user_id=" . $getDataMember['user_id'] . "&otb=Chat%20board|", true); ?> class="chat-unread">
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
                                        $notif = DB_UNREAD($oid, $listID);
                                        $unread = $v['user_id_receive'] == $oid && $v['read_status'] == 0 ? count($notif['data']) : '';
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
                                        <?php $unreadText = $v['user_id_receive'] == $oid && $v['read_status'] == 0 ? 'text-bold' : '' ?>
                                        <p class="<?php echo $unreadText ?>"><?php echo $msg; ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
            <div class="nano-pane">
                <div class="nano-slider" style="height: 305px; transform: translate(0px, 0px);"></div>
            </div>
        </div>
    </div>
</div>
<?php
if ($ct == 'group_chat') { ?>
    <div style="margin-left: 240px;">
        <div id="page-content">
            <div class="panel">
                <div class="media-block pad-all bord-btm">
                    <div class="media-left">
                        <img class="img-circle img-xs" src="<?php echo $_groupConfig[$keysname]['picture']; ?>" alt="Profile Picture">
                    </div>
                    <div class="media-body">
                        <p class="mar-no text-main text-bold text-lg"><?php echo $_groupConfig[$keysname]['name']; ?></p>
                    </div>
                </div>
                <div class="nano has-scrollbar" style="height: 60vh; background-color: <?php echo $themeColor; ?>;">
                    <div class="nano-content" tabindex="0" style="right: -17px;" id="chat-content">
                        <div class="panel-body chat-body media-block" id="chat-data-group">
                            <?php
                            foreach ($getallchatgroup['data'] as $v) {
                                $time = date('H:i', strtotime($v['chat_time']));
                                $time2 = date('Y-m-d H:i', strtotime($v['chat_time']));
                                if ($v['user_id_send'] != $oid) {
                                    $getuser = DB_GET('member_member', ['user_id' => $v['user_id_send']]);
                                    $aPicture = getAdminUserById($getuser['user_id']);
                                    $userPic = Func_Pic_Corp($aPicture['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
                            ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="chat-user">
                                                <p class="text-bold" style="text-align: left;"><?php echo $getuser['firstname'] ?></p>
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
                                if ($v['user_id_send'] == $oid) {
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
                            <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="nano-pane">
                        <div class="nano-slider" style="height: 118px; transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div class="pad-all">
                    <form action="" method="post" name="formChatGroup" id="formChatGroup">
                        <input type="hidden" name="ac" id="ac" value="add2">
                        <div class="input-group">
                            <textarea name="msg" id="msg" placeholder="พิมพ์ข้อความของคุณ" class="form-control form-control-trans" autocomplete="off" autofocus rows="1" maxlength="1024" style="resize: none; height: auto; overflow: hidden;"></textarea>
                            <span class="input-group-btn">
                                <button class="btn btn-icon add-tooltip" data-original-title="Emoticons" data-target="#demo-default-modal" data-toggle="modal" type="button"><i class="demo-pli-smile icon-lg"></i></button>
                                <button class="btn btn-icon add-tooltip" data-original-title="Send" type="submit" id="submitBtn"><i class="demo-pli-paper-plane icon-lg"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<?php
if ($ct === 'user_chat' && $uid !== '') { ?>
    <div style="margin-left: 240px;">
        <div id="page-content">
            <div class="panel">
                <div class="media-block pad-all bord-btm">
                    <?php
                    $aPicture = getAdminUserById($getuser['user_id']);
                    $userPic = Func_Pic_Corp($aPicture['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
                    ?>
                    <div class="media-left">
                        <img class="img-circle img-xs" src=<?php echo $userPic; ?> alt="Profile Picture">
                    </div>
                    <div class="media-body">
                        <p class="mar-no text-main text-bold text-lg"><?php echo $getuser['firstname'] . " " . $getuser['lastname']  ?></p>
                    </div>
                </div>
                <div class="nano has-scrollbar" style="height: 60vh; background-color: <?php echo $themeColor; ?>;">
                    <div class="nano-content" tabindex="0" style="right: -17px;" id="chat-content">
                        <div class="panel-body chat-body media-block" id="chat-data-user">
                            <?php
                            foreach ($getallchat['data'] as $v) {
                                $time = date('H:i', strtotime($v['chat_time']));
                                $time2 = date('Y-m-d H:i', strtotime($v['chat_time']));
                                if ($v['user_id_send'] == $uid && $v['user_id_receive'] == $oid) {
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
                                if ($v['user_id_send'] == $oid && $v['user_id_receive'] == $uid) {
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
                        </div>
                    </div>
                    <div class="nano-pane">
                        <div class="nano-slider" style="height: 118px; transform: translate(0px,0px);"></div>
                    </div>
                </div>
                <div class="pad-all">
                    <form action="" method="post" name="formChatUser" id="formChatUser">
                        <input type="hidden" name="ac" id="ac" value="add">
                        <div class="input-group">
                            <textarea name="msg" id="msg" placeholder="พิมพ์ข้อความของคุณ" class="form-control form-control-trans" autocomplete="off" autofocus rows="1" maxlength="1024" style="resize: none; height: auto; overflow: hidden;"></textarea>
                            <span class="input-group-btn">
                                <button class="btn btn-icon add-tooltip" data-original-title="Emoticons" data-target="#demo-default-modal" data-toggle="modal" type="button"><i class="demo-pli-smile icon-lg"></i></button>
                                <button class="btn btn-icon add-tooltip" data-original-title="Send" type="submit" id="submitBtn"><i class="demo-pli-paper-plane icon-lg"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
} elseif ($ct === "user_chat" && $uid === '') {
?>
    <div style="margin-left: 240px;">
        <div id="page-content">
            <div class="panel">
                <div class="media-block pad-all bord-btm">
                    <div class="media-left">
                    </div>
                    <div class="media-body">
                        <p class="mar-no text-main text-bold text-lg">เลือกแชทที่ต้องการคุยในหน้า Member Chat</p>
                    </div>
                </div>
                <div class="nano has-scrollbar" style="height: 60vh; background-color: <?php echo $themeColor; ?>;">
                    <div class="nano-content" tabindex="0" style="right: -17px;" id="chat-content">
                        <div class="panel-body chat-body media-block" id="chat-data-group">
                        </div>
                    </div>
                    <div class="nano-pane">
                        <div class="nano-slider" style="height: 118px; transform: translate(0px, 0px);"></div>
                    </div>
                </div>
                <div class="pad-all">
                    <form action="" method="post" name="formChatGroup" id="formChatGroup">
                        <input type="hidden" name="ac" id="ac" value="add2">
                        <div class="input-group">
                            <textarea disabled name="msg" id="msg" placeholder="พิมพ์ข้อความของคุณ" class="form-control form-control-trans" autocomplete="off" autofocus rows="1" maxlength="1024" style="resize: none; height: auto; overflow: hidden;"></textarea>
                            <span class="input-group-btn">
                                <button disabled class="btn btn-icon add-tooltip" data-original-title="Emoticons" data-target="#demo-default-modal" data-toggle="modal" type="button"><i class="demo-pli-smile icon-lg"></i></button>
                                <button disabled class="btn btn-icon add-tooltip" data-original-title="Send" type="submit" id="submitBtn"><i class="demo-pli-paper-plane icon-lg"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade" id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bord-btm">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h4 class="modal-title">Emoticons</h4>
            </div>
            <div class="modal-body">
                <p class="text-semibold text-main">Choose your emoticon ...</p>
                <?php foreach ($_emoticonsConfig as $v) { ?>
                    <button class="btn chat-emoticons"><img src="<?php echo $v['picture'] ?>" class="img-xs chat-emoticons-image" alt="Emoticon Picture"></button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    function scrollToBottom() {
        var chatContent = document.getElementById('chat-content');
        chatContent.scrollTop = chatContent.scrollHeight;
    }
    scrollToBottom();
    document.getElementById('submitBtn').disabled = true;
</script>