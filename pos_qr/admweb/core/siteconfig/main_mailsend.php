<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Mailing History ได้', 'redirect', 'SET');
$abcDel = REQ_get('del', 'post', 'str', '');
$page 	= (@$_REQUEST['page'] > 0) ? @$_REQUEST['page'] : 1;
$alog 	= _systemlogs_getMailLogs($num = 20, $page);
$currentdate = date('dmY', _TIME_);
$befortime = date('dmY', _TIME_ - 86400);
if (_AC_ == "delete" && count($abcDel) > 0) {
	PERMIT::_PERMIT(_MODULE_, 'module|mp|ac', 'สามารถลบ Mailing History ได้', 'redirect', '');
	foreach ($abcDel as $k => $v) {
		_systemlogs_delete_mailLogs($v);
	}
	setRaiseMsg('Data deletion is complete. please wait.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . _MODULE_ . "&mp=" . _MP_ . "");
	exit;
}

_systemlogs_delete_admin_oldlogs($num = 500);
?>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow">Administrator access history</h1>
	</div>
</div>
<div id="page-content">

	<div class="row">
		<div class="col-xs-12">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Mailsend History</h3>
				</div>
				<div class="panel-body">
					<?php displayRaiseMsg(); ?>
					<h2><?php echo @$_tabs['current']['name']; ?></h2>
					<form action="" method="post" name="frmList">
						<input type="hidden" name="ac" value="delete">
						<div style="padding-bottom: 10px;"><button id="demo-btn-addrow" class="btn btn-danger" onclick="return ConfirmDelete();">Delete selected data</button></div>

						<!-- <tr>
								<td align="left"><a href="javascript:ConfirmDelete()" class="submit">Delete selected data</a></td>
								<td align="right"><?php BuilListPage($alog, _admin_buil_link('index.php?module=' . _MODULE_ . '&mp=' . _MP_ . ''), $page); ?></td>
							</tr> -->

						<table class="table table-striped">
							<thead>
								<tr>
									<td><input type="checkbox" onclick="FunCheckedAll(this.checked, 'checkall');"></td>
									<td>ID</td>
									<td>Title Sent</td>
									<td>To</td>
									<td>Time</td>
									<td>Action Open</td>
								</tr>
								<thead>
									<?php
									$count = 0;
									$bgc = "#F6F6F6";
									$abgcolor = array();
									if (count(@$alog['data']) > 0 && is_array(@$alog['data'])) {
										foreach ($alog['data'] as $k => $v) {
											$count++;
											$bgc = ($bgc == "#F6F6F6") ? "#f2f2f2" : "#F6F6F6";
											$abgcolor[$count] = $bgc;
									?>
											<tr id="row<?php echo $count; ?>" bgcolor="<?php echo $bgc; ?>" height="22" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"<?php echo $bgc; ?>");'>
												<td class="gridRow" align="center"><input type="checkbox" id="check<?php echo $count; ?>" name="del[]" value="<?php echo $v['logs_id']; ?>" onclick="if(this.checked==true){ selectRow('row<?php echo $count; ?>'); }else{ deselectRow('row<?php echo $count; ?>', '<?php echo $bgc; ?>'); }"></td>
												<td align="center"><?php echo $v['logs_id']; ?></td>
												<td align="left"><?php echo $v['subject']; ?></td>
												<td align="left"><?php echo $v['sendto']; ?></td>
												<td class="gridRow" align="center">
													<?php
													$checkdate = date('dmY', $v['logs_time']);
													if ($currentdate == $checkdate) {
														echo '<b>วันนี้</b> เวลา ' . strTimeFormat($v['logs_time'], " %H:%M");
													} elseif ($befortime == $checkdate) {
														echo '<b>เมื่อวานนี้</b> เวลา ' . strTimeFormat($v['logs_time'], " %H:%M");
													} else {
														echo strTimeFormat($v['logs_time'], "%d %b %Y %H:%M");
													}
													?>
												</td>
												<td align="center"><a href="popFrame.php?module=<?php echo _MODULE_ ?>&mp=viewmaillogs&id=<?php echo $v['logs_id']; ?>" class="popupiframe button">Open</a></td>
											</tr>
										<?php }
									} else { ?>
										<tr height="50">
											<td colspan="6" align="center">There is no data to send mail from the system.</td>
										</tr>
									<?php } ?>
						</table>
						<div style="padding: 10px;" align="right"></div>
						<?php BuilListPage($alog, _admin_buil_link('index.php?module=' . _MODULE_ . '&mp=' . _MP_ . ''), $page); ?>
				</div>
				</form>
				<script language="javascript">
					function selectAll() {
						if (document.getElementById("checkAll").checked == true) {
							document.getElementById("checkAll").checked = true;
							<? for ($i = 1; $i <= $count; $i++) {
								echo "document.getElementById(\"check$i\").checked=true; document.getElementById(\"row$i\").style.background='#D6DEEC'; \n";
							}	?>
						} else {
							document.getElementById("checkAll").checked = false;
							<? for ($i = 1; $i <= $count; $i++) {
								echo "document.getElementById(\"check$i\").checked=false; document.getElementById(\"row$i\").style.background='" . $abgcolor[$i] . "'; \n";
							} ?>
						}
					}
				</script>
			</div>
		</div>
	</div>
</div>
</div>