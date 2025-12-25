<?php
$id = REQ_get('id', 'requset', 'int', '');
$notifyList = DB_NOTIF_LIST($id);
$getNotify = count($notifyList['data']);
?>
<i class="demo-pli-bell"></i>
<?php if ($getNotify > 0) { ?>
    <span class="badge badge-header badge-danger" style="padding: 2px 0px;font-size: 16px;margin-top: 6px;right: 0px;font-weight:normal;min-width: 20px;"><?php echo $getNotify; ?></span>
<?php } ?>