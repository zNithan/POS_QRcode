<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Member Chat ได้', 'redirect', 'SET');
$id = login_logout::getAdminId();
$page         = REQ_get('page', 'request', 'int', '1');
$keysword     = REQ_get('keysword', 'request', 'str', '');
$getUserList  = DB_LIST('member_user', 'user_id != ' . $id);

if (_AC_ == 'search') {
    CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&keysword=" . $keysword . "&ac=viewsearch");
    exit;
} elseif (_AC_ == 'viewsearch') {
    PERMIT::_PERMIT(_MODULE_, 'module|mp|ac', 'สามารถค้นหา Member Chat ได้', 'redirect', '');
    $getUserList = getSearchMember($id, $keysword, 20, $page);
    $pagelink = _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "&ac=" . _AC_ . "&keysword=" . $keysword);
} else {
    $getUserList = DB_LIST('member_user', ['user_id' => ['!=', $id]], 20, $page);
    $pagelink = _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
}
?>
<div id="page-head">
    <div id="page-title">
        <h1 class="page-header text-overflow">Member Chat</h1>
    </div>
</div>
<div id="page-content">
    <div class="row">
        <div class="row pad-btm">
            <form action="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . ""); ?>" method="post" class="col-sm-10 col-sm-offset-1 pad-hor">
                <input type="hidden" name="ac" value="search">
                <div class="input-group mar-btm">
                    <input type="text" placeholder="Search for members chat" class="form-control input-lg" name="keysword" autocomplete="off" value="<?php echo $keysword; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg input-lg" type="submit" style="margin-left: 5px;">SEARCH</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($getUserList['data']) && count($getUserList['data']) > 0) { ?>
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th width="50"></th>
                                    <th>Full name</th>
                                    <th>E-mail</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($getUserList['data'] as $v) {
                                    $getUser = DB_GET('member_member', ['user_id' => $v['user_id']], 'ORDER BY user_id');
                                    $getUser2 = DB_GET('member_online', ['user_id' => $v['user_id']], 'ORDER BY user_id');
                                    $time = isset($getUser2['onlineEndTime']) ? $getUser2['onlineEndTime'] : 0;
                                    $isStatus = (_TIME_ < $time) ? 'Online' : 'Offline';
                                    $isColor = ($isStatus === 'Online') ? 'green' : 'red';
                                    $userPic = Func_Pic_Corp($getUser['picture'], TEMPLATE_URL . '/img/profile-photos/1.png', 'w=150&h=150');
                                    $fullname = "{$getUser['salutation']} {$getUser['firstname']} {$getUser['lastname']}"; ?>
                                    <tr>
                                        <td><img class="img-xs img-circle" src="<?php echo $userPic; ?>" alt="Profile Picture"></td>
                                        <td><?php echo $fullname; ?></td>
                                        <td><?php echo $getUser['email']; ?></td>
                                        <td><?php echo $getUser['phone']; ?></td>
                                        <td><?php echo $isStatus; ?>&nbsp;<i class="fa fa-circle fa-xs" style="font-size: 12px; color: <?php echo $isColor; ?>;"></i></td>
                                        <td class="min-width"><a href="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=chat_board&ct=user_chat&user_id=" . $getUser['user_id']); ?>" class="add-tooltip" data-original-title="Chat"><i class="fa fa-comment-o fa-lg"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div>
                                <p>Find all <?php echo $getUserList['num_rows']; ?> items / display 20 items per page</p>
                            </div>
                        </div>
                        <div class="col-sm-7 text-right">
                            <?php BuilListPage($getUserList, $pagelink, $page); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <br><br>
            <div class="text-center">
                <p class="h4 text-uppercase text-bold">There are no members according to the details you searched.</p>
                <div class="pad-btm">
                    <p>Sorry, but the member you are looking for has not been found on our database.</p>
                </div>
                <div><a href="<?php echo _admin_buil_link("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . ""); ?>" class="btn btn-mint dbfont22">Back to the total page</a></div>
            </div>
        <?php } ?>
    </div>
</div>