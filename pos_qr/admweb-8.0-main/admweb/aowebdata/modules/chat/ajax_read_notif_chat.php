<?php
$id = REQ_get('id', 'requset', 'int', '');
$notifyList = DB_NOTIF_LIST($id);
?>
<div class="nano scrollable has-scrollbar" style="height: 300px;">
    <div class="nano-content" tabindex="0" style="right: -17px;">
        <?php if (count(@$notifyList['data']) > 0) { ?>
            <ul class="head-list">
                <?php foreach ($notifyList['data'] as $v) {
                    $aPic = getAdminUserById($v['user_id']);
                    $userPic = Func_Pic_Corp($aPic['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
                    $fullname = "{$v['firstname']} {$v['lastname']}";
                    $msg = preg_match('/<img[^>]+>/i', $v['message']) ? 'ข้อความอีโมติคอน' : str_replace("<br />", " ", $v['message']); ?>
                    <li>
                        <a class="media" href="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=chat_board&ct=user_chat&user_id=" . $v['user_id']); ?>">
                            <div class="media-left">
                                <img class="img-circle img-sm" alt="Profile Picture" src="<?php echo $userPic; ?>">
                            </div>
                            <div class="media-body">
                                <p class="mar-no text-nowrap text-main text-semibold"><?php echo $fullname; ?></p>
                                <p class="mar-no text-nowrap text-main"><?php echo "ข้อความล่าสุด: " . $msg; ?></p>
                                <small><?php echo $v['chat_time']; ?></small>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="text-center" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                <p class="h4 text-bold">ยังไม่มีข้อความส่งถึงคุณ</p>
            </div>
        <?php } ?>
    </div>
    <?php if (count(@$notifyList['data']) > 3) { ?>
        <div class="nano-pane">
            <div class="nano-slider" style="height: 118px; transform: translate(0px,0px);"></div>
        </div>
    <?php } ?>
</div>