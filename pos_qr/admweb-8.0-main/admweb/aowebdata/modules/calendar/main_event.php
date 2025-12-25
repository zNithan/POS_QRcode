<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Calendar Event ได้', 'redirect', 'SET');
if (!is_dir(PATH_UPLOAD . '/calendar')) {
    mkdir(PATH_UPLOAD . '/calendar', 0777, true);
};
updateYear();
if (_AC_ == 'save') {
    PERMIT::_PERMIT(_MODULE_, 'You can process calendar event', 'สามารถดำเนินการ Event ได้', 'redirect', '');
    $name = REQ_get('name', 'post', 'str', '');
    $html = REQ_get('html', 'post', 'str', '');
    $color = REQ_get('color', 'post', 'str', '');
    if ($name !== '' && $html !== '' && $color !== '') {
        $fname = PATH_UPLOAD . '/calendar/event.txt';
        $event = file_exists($fname) ? read_txt_json($fname) : [];
        if (count($event) >= 12) {
            setRaiseMsg('Save event is failed, Maximum 12 event names.', _TIME_, 1);
            CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
            return;
        }
        if (isset($event[$name])) {
            setRaiseMsg('Save event is failed, Duplicate event name.', _TIME_, 1);
            CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
            return;
        }
        $event[$name][$html] = $color;
        write_txt_json($fname, $event);
    }
    setRaiseMsg('Save event is successfully.', _TIME_, 0);
    CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
    exit;
}
if (_AC_ == 'del') {
    PERMIT::_PERMIT(_MODULE_, 'You can process calendar event', 'สามารถดำเนินการ Event ได้', 'redirect', '');
    $name = REQ_get('name', 'post', 'str', '');
    delEvent($name);
    setRaiseMsg('Delete event is successfully.', _TIME_, 0);
    CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
    exit;
}
?>
<div id="page-content">
    <?php displayRaiseMsg(); ?>
    <form method="post" name="form1" id="form1">
        <input hidden name="ac" class="ac" value="save">
        <div class="panel">
            <div class="panel-body">
                <div class="fixed-fluid">
                    <div class="fixed-sm-200 pull-sm-left fixed-right-border">
                        <?php $oUser = login_logout::getAdminUsername(); ?>
                        <?php if ($oUser === "superadmin") { ?>
                            <button type="button" class="btn btn-block btn-primary btn-lg text-uppercase" data-target="#demo-default-modal" data-toggle="modal" style="height:45px">Add Event</button>
                            <hr>
                        <?php } ?>
                        <p class="text-main text-bold text-md">Event Day List</p>
                        <div id="demo-external-events">
                            <?php
                            $fname = PATH_UPLOAD . '/calendar/event.txt';
                            if (file_exists($fname)) {
                                $event = read_txt_json($fname);
                                foreach ($event as $k => $v) { ?>
                                    <div class="fc-event" data-class="<?php echo implode(", ", $v); ?>" style="display: flex; justify-content: space-between; align-items: center;">
                                        <span><?php echo $k; ?></span>
                                        <?php if ($oUser === "superadmin") { ?>
                                            <i class="fa fa-times-circle" style="cursor: pointer;" onclick="removeEvent('<?php echo $k; ?>');"></i>
                                        <?php } ?>
                                    </div>
                                <?php }
                            } else { ?>
                                <p class="text-muted text-sm">There are currently no events.</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="fluid">
                        <div id='demo-calendar'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bord-btm">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">New Event</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right">
                                <span class="text-danger">*</span> Name :
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Event Name" autocomplete="off" autofocus required>
                            </div>
                        </div> <br>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right">
                                <span class="text-danger">*</span> HTML :
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="html" placeholder="Event HTML" autocomplete="off" required>
                            </div>
                        </div> <br>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right">
                                <span class="text-danger">*</span> Color :
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="color" id="color">
                                    <option value="primary">Blue</option>
                                    <option value="info">Cyan</option>
                                    <option value="success">Green</option>
                                    <option value="mint">Mint</option>
                                    <option value="warning">Yellow</option>
                                    <option value="danger">Red</option>
                                    <option value="pink">Pink</option>
                                    <option value="purple">Purple</option>
                                    <option value="dark">Black</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button type="submit" class="btn btn-mint"><i class="fa fa-save" style="font-size: 12px;"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>