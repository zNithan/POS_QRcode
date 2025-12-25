<?php
$time = _TIME_;
$Year = _YY_;
$Month = _MM_;
$Day = _DD_;

$keysname 	= REQ_get('keysname', 'request', 'str', '');
$ac = REQ_get('ac', 'request', 'str', '');
$id = REQ_get('id', 'request', 'int', '');
@$widthIcon = @$aArticleConfig['widthIcon'];
$group = '0';
$file_id = REQ_get('fid', 'get', 'str', '');
$page = 'group';
if ($id == '' || $isOpens['isOpenGroup'] != true) {
	setRaiseMsg('เมนูนี้ไม่ได้เปิดสิทธิ์ การแก้ไขหมวดหมู่ หรือ ไม่พบ id .', _TIME_, 1);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=" . $mp . "&inc=listgroup&keysname=" . $keysname);
	exit;
}

///////////////////////////////////////////////////////
/////////////////// isSecurMode /////////////
///////////////////////////////////////////////////////
$isSecurMode = GlobalConfig_get('isSecurMode');
if (in_array($ac, array('edit')) && $isSecurMode == 1) {
	setRaiseMsg('Secur Mode.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=" . $mp . "&inc=listgroup&keysname=" . $keysname);
	exit;
}
///////////////////////////////////////////////////////
/////////////////// isSecurMode /////////////
///////////////////////////////////////////////////////

if ($ac == 'edit') {
	$sort 					= REQ_get('sort', 'post', 'int', 0);
	$parent_id = REQ_get('parent_id', 'post', 'int', 0);
	$status 			= (REQ_get('status', 'post', 'str') == 'y') ? 0 : 1;
	$iconname 	= '';
	$extraOption = REQ_get('extraOption', 'request', 'str');
	$extra1 = REQ_get('extra_group1', 'request', 'str');
	$extra2 = REQ_get('extra_group2', 'request', 'str');
	$extra3 = REQ_get('extra_group3', 'request', 'str');
	$extra4 = REQ_get('extra_group4', 'request', 'str');
	$extra5 = REQ_get('extra_group5', 'request', 'str');
	//$Option = count($extraOption) > 1 ? implode(',', $extraOption) : $extraOption;

	PG_updateArticlesGroup($id, $parent_id, $sort, $extraOption, $status, $extra1, $extra2, $extra3, $extra4, $extra5);

	if (isset($_FILES['iconview']) && count(@$_FILES['iconview']) > 0 && @$_FILES['iconview']['error'] == 0) {
		$extention = strtolower(end(explode('.', @$_FILES['iconview']['name'])));
		if (in_array($extention, $aArticleConfig['icon'])) {
			$folder_icon = 'articles_icon/' . $Year . '_' . $Month;
			$path_icon_mkdir = PATH_UPLOAD . '/' . $folder_icon;
			if (!is_dir($path_icon_mkdir)) {
				mkdir($path_icon_mkdir, 0777);
			}

			$iconname = $folder_icon . '/' . $id . '_group_' . $time . '.' . $extention;
			$filePath = PATH_UPLOAD . '/' . $iconname;
			@move_uploaded_file(@$_FILES['iconview']['tmp_name'], $filePath);
		} else {
			setRaiseMsg('Cannot upload icon.', _TIME_ + 1, 1);
		}
	}


	if (isset($_FILES['iconview2']) && count(@$_FILES['iconview2']) > 0 && @$_FILES['iconview2']['error'] == 0) {
		$extention = strtolower(end(explode('.', @$_FILES['iconview2']['name'])));
		if (in_array($extention, $aArticleConfig['icon'])) {
			$folder_icon = 'articles_icon/' . $Year . '_' . $Month;
			$path_icon_mkdir = PATH_UPLOAD . '/' . $folder_icon;
			if (!is_dir($path_icon_mkdir)) {
				mkdir($path_icon_mkdir, 0777);
			}

			$iconname2 = $folder_icon . '/' . $id . '_group_' . $time . '.' . $extention;
			$filePath = PATH_UPLOAD . '/' . $iconname2;
			@move_uploaded_file(@$_FILES['iconview2']['tmp_name'], $filePath);
		} else {
			setRaiseMsg('Cannot upload icon.', _TIME_ + 1, 1);
		}
	}
	PG_updateIconGroup($id, $iconname, $iconname2);

	$frm = REQ_get('frm', 'post', 'array', array('th'));
	foreach ($frm as $k => $v) {
		$v['name'] 				= @$v['name'] != '' ? $v['name'] : '- - No title - -';
		$frm[$k]['group_id'] 	= $id;
		$frm[$k]['name']		= (@$v['name'] != '') ? mysqlPrep($v['name']) : '';
		$frm[$k]['detail'] 		= (@$v['detail'] != '') ? $v['detail'] : '';
		$frm[$k]['detailExtra1']   = (@$v['detailExtra1'] != '') ? $v['detailExtra1'] : '';
		$frm[$k]['detailExtra2']   = (@$v['detailExtra2'] != '') ? $v['detailExtra2'] : '';
		$frm[$k]['slug']   = (@$v['slug'] != '') ? sanitizeSlug($v['slug']) : '';
	}

	PG_updateArticlesGroupContent($frm);

	$aSortimg = REQ_get('sortimg', 'request', 'array');
	if (is_array($aSortimg) && count($aSortimg) > 0) {
		foreach ($aSortimg as $k => $v) {
			PG_update_arSort_Group_img($k, $v);
		}
	}

	$aEditimg = @$_REQUEST['edit'];
	if (is_array($aEditimg) && count($aEditimg) > 0) {
		$arEdit = array();
		foreach ($aEditimg['fid'] as $k => $v) {
			$arEdit['title']    = (isset($aEditimg['title'][$v])) ? $aEditimg['title'][$v] : '';
			$arEdit['detail'] = (isset($aEditimg['detail'][$v])) ? $aEditimg['detail'][$v] : '';
			$arEdit['detail2'] = (isset($aEditimg['detail2'][$v])) ? $aEditimg['detail2'][$v] : '';
			PG_update_allData_Group_img($v, $arEdit);
		}
	}


	if ($isOpens['isMark']) {
		$aMark = @$_REQUEST['aMark'];
		if (is_array($aMark) && count($aMark) > 0) {
			foreach ($aMark as $k => $v) {
				$v = ($v == 1) ? 1 : 0;
				PG_updateIsMarkGroupImg($k, $v);
			}
		}
	}
	$aArticleConfig['attach'] = (count($aArticleConfig['attach']) > 0) ? $aArticleConfig['attach'] : array('pdf', 'doc', 'docx');
	$aFile = REQ_get('attachFile', 'file', 'array');
	$aFileText = REQ_get('attachTextFile', 'request', 'array');

	$isResizeAttach = (@$_REQUEST['isResizeAttach'] == 1) ? 1 : 0;
	if (isset($aFile['name']) && count($aFile['name']) > 0) {

		/////////////// path for upload ////////////////
		$folder_pic = 'articles_img_group/' . $Year . '_' . $Month;
		$miniPath = PATH_UPLOAD . '/' . $folder_pic . '/' . $id . '/mini';
		$bigPath = PATH_UPLOAD . '/' . $folder_pic . '/' . $id . '/big';

		////////////////// check path //////////////////
		$aCheckPath = array(
			PATH_UPLOAD,
			PATH_UPLOAD . '/articles_img_group',
			PATH_UPLOAD . '/' . $folder_pic,
			PATH_UPLOAD . '/' . $folder_pic . '/' . $id,
			$miniPath,
			$bigPath
		);

		foreach ($aCheckPath as $vPath) {
			if (!is_dir($vPath)) {
				mkdir($vPath, 0777);
			}
		}
		////////////////// check path //////////////////

		$i = 0;
		$time = _TIME_;
		$aUpName = array();
		$counter = PG_getSortGroupPictureByGroupID($id);
		$counterSort = $counter['sort'] + 1;
		foreach ($aFile['error'] as $kFile => $vFile) {
			if ($vFile == 0) {
				$i = $i + 1;
				$extention = strtolower(end(explode('.', $aFile['name'][$kFile])));

				$fileMini = $miniPath . '/' . $time . '_' . $i . '.' . $extention;
				$fileMiniUrl = 'articles_img_group/' . $id . '/mini/' . $time . '_' . $i . '.' . $extention;
				if (is_file($fileMini)) {
					unlink($fileMini);
				}

				$fileBig = $bigPath . '/' . $time . '_' . $i . '.' . $extention;
				$fileBigUrl = $folder_pic . '/' . $id . '/big/' . $time . '_' . $i . '.' . $extention;
				if (is_file($fileBig)) {
					unlink($fileBig);
				}

				if (move_uploaded_file($aFile['tmp_name'][$kFile], $fileBig)) {
					PG_addArticlesPictureGroup($id, $counterSort, $fileMiniUrl, $fileBigUrl, @$aFileText[$kFile]);
					$counterSort++;
					$aUpName[] = $time . '_' . $i . '.' . $extention;
					$thumb = new thumbnail();
					$thumbinc = $thumb->resize_thumbnail($fileBig);

					$thumb->size_width(300);
					$thumb->jpeg_quality(99);
					$thumb->save($fileMini);
					$aUpName[] = $time . '_' . $i . '.' . $extention;
				}
			}
		}
		if (count($aUpName) > 0) {
			$strUpload = implode(' , ', $aUpName);
			$updatetxt .= ', Picture, ' . $strUpload;
			updateKeysnamePictureGroup($id, $keysname);
		}
	}

	Func_Addlogs("[{$keysname}] Edit ArticleGroup ID {$id}");
	setRaiseMsg('Database successfully Add.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=" . $mp . "&inc=listgroup&id=" . $id . "&keysname=" . $keysname);
	exit;
} elseif ($ac == 'deleteicon') {
	PG_deleteIconGroup($id);
	setRaiseMsg('Database successfully deleted Icon.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=" . $mp . "&inc=editgroup&id=" . $id . "&keysname=" . $keysname);
	exit;
} elseif ($ac == 'deleteimg') {
	PG_deleteImgGroup($id);
	setRaiseMsg('Database successfully deleted Icon.', _TIME_, 0);
	CustomRedirectToUrl("index.php?module=" . $module . "&mp=" . $mp . "&inc=editgroup&id=" . $id . "&keysname=" . $keysname);
	exit;
}

$aGroupEdit = PG_getArticlesGroupByID($id);
//$extraOption = explode(',', $aGroupEdit['extraOption']);
// foreach ($extraOption as $k => $v) {
// 	for ($i = 1; $i <= 6; $i++) {
// 		if ($v == $i) {
// 			$che[$i] = ' checked="checked" ';
// 		}
// 	}
// }
// $che[0] = @count($extraOption) > 5 ? ' checked="checked" ' : '';

$aGroupAll = pg_getAllGroup($keysname);
//$r = $rMain = array();
// foreach ($rMain as $k => $v) {
// 	$rMain[$k] = $v;
// 	@$rMain[$k]['sub'] = @$r[$v['group_id']];
// }


if ($isOpens['isAttachPic']) {
	$aPictureAtt = PG_getAllPictureGroupByArticlesID($id);
}


$Images_total = 8;
$Images_num_rows = ($Images_total / 2);


include 'css/editgroup.php';
?>


<form action="" method="post" name="form1" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="ac" value="edit" />
	<div id="page-head">
		<div id="page-title">
			<h1 class="page-header text-overflow">UPDATE GROUP</h1>
		</div>
	</div>
	<div id="page-content">
		<div class="row pad-btm">
			<div class="col-sm-6 col-sm-offset-6 toolbar-right text-right">
				<button class="btn btn-mint" style="font-size: 24px; font-family: db_ozone_xregular; "> <i class="fa fa-save" style="font-size: 18px;"></i> Update &amp; Publish</button>
			</div>
		</div>
		<br clear="all" />
		<?php echo displayRaiseMsg(); ?>
		<div class="fixed-fluid">
			<div class="fixed-sm-300 pull-sm-right" style="background-color: transparent !important;">

				<div class="panel">
					<div class="panel-body">
						<div class="form-horizontal">
							<p class="text-main text-bold text-uppercase mainTxtBorderGreen">Display</p>
							<div class="dropzone-container">
								<div class="fallback">
									<input class="toggle-switch" id="demo-allow-show" value="y" type="checkbox" name="status" <?php echo (isset($aGroupEdit['status']) && $aGroupEdit['status'] != 1) ? 'checked' : ''; ?>>
									<label for="demo-allow-show"> <span style="line-height: 28px;">Close</span> | <span style="color: #8BC34A;line-height: 28px;"> Open </span> </label>
								</div>
							</div>
							<br />
						</div>

						<?php if ($isOpens['isOpenGroup']) { ?>
							<div class="form-group">
								<label class="col-sm-12 control-label text-left"><?php echo @$tagname['isOpenGroup']; ?></label>
								<div class="col-sm-12">
									<div class="select-md" style="width: 100%;margin-bottom: 20px;">
										<select name="parent_id" id="parent_id" style="font-size: 18px;width: 100%;">
											<option value="0">== Head Group ==</option>
											<?php
											$curparent_id = @$aGroupEdit['group_parent_id'];
											foreach ($aGroupAll['data'] as $k => $v) {
												if ($aGroupEdit['group_id'] == $v['group_id']) {
													continue;
												}
												$se = ($curparent_id == $v['group_id']) ? ' selected="selected" ' : '';
												if ($v['group_parent_id'] == 0) {
													$se = ($v['group_id'] == $curparent_id) ? ' selected="selected" ' : '';
													echo '<option value="' . $v['group_id'] . '" ' . $se . '> ' . $v['group_name'] . '</option>';
													$aSubGroup = PG_getAllGroupByGID($v['group_id']);
													// if ($aSubGroup['num_rows'] > 0) {
													// 	foreach ($aSubGroup as $kk => $vv) {
													// 		$se = ($vv['group_id'] == $curparent_id) ? ' selected="selected" ' : '';
													// 		echo '<option value="' . $vv['group_id'] . '" ' . $se . ' style="color:#817F82;"> &nbsp;&nbsp;&nbsp;&nbsp;&rarr; ' . $vv['group_name'] . ' </option>';
													// 	}
													// }
												}
											} ?>
										</select>
									</div>
								</div>
							</div>
							<br />
						<?php } ?>
					</div>
				</div>
				<?php include 'option/isAttachGroupAll.php'; ?>
				<?php include 'option/group_extraOption.php'; ?>
				<div class="panel">
					<div class="panel-body">
						<div class="form-horizontal">
							<p class="text-main text-bold text-uppercase mainTxtBorderGreen">Order By</p>
							<div class="dropzone-container">
								<div class="fallback" align="left">
									<div class="col-sm-12" style="padding-bottom: 10px;">
										<input type="text" name="sort" id="sort" class="form-control" placeholder="เลขน้อยอยู่บนสุด" value="<?php echo $aGroupEdit['sort']; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if ($isOpens['isGroupExtra1'] || $isOpens['isGroupExtra2'] || $isOpens['isGroupExtra3'] || $isOpens['isGroupExtra4'] || $isOpens['isGroupExtra5']) { ?>
					<div class="panel">
						<div class="panel-body">
							<div class="form-horizontal">
								<?php if ($isOpens['isGroupExtra1']) {
									include 'option/group_extra1.php';
								} ?>
								<?php if ($isOpens['isGroupExtra2']) {
									include 'option/group_extra2.php';
								} ?>
								<?php if ($isOpens['isGroupExtra3']) {
									include 'option/group_extra3.php';
								} ?>
								<?php if ($isOpens['isGroupExtra4']) {
									include 'option/group_extra4.php';
								} ?>
								<?php if ($isOpens['isGroupExtra5']) {
									include 'option/group_extra5.php';
								} ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="tab-base">
							<ul class="nav nav-tabs">
								<?php
								foreach ($aConfig['language'] as $kLang => $vLang) {
									$act = ($kLang == DEFAULT_LANGEUAGE) ? 'active text-bold' : 'none_active';
									echo '<li class="' . $act . '"><a data-toggle="tab" href="#demo-lft-tab-' . $kLang . '">' . $vLang . '</a></li>';
								}
								if ($isOpens['isGroupAttachPic']) {
									echo '<li class="none_active"><a data-toggle="tab" href="#uploadPic">Uploads Picture</a></li>';
								}

								?>
							</ul>
							<div class="tab-content">
								<?php foreach ($aConfig['language'] as $kLang => $vLang) { ?>
									<div id="demo-lft-tab-<?php echo $kLang; ?>" class="tab-pane fade <?php echo ($kLang == DEFAULT_LANGEUAGE) ? 'active in' : ' in'; ?>">

										<div class="form-group">
											<div><?php echo $tagname['isTitle']; ?></div>
											<input type="text" name="frm[<?php echo $kLang; ?>][name]" placeholder="<?php echo $tagname['isTitle']; ?>" class="form-control input-md" value="<?php echo $aGroupEdit['content'][$kLang]['group_name']; ?>" autofocus />
										</div>

										<?php if ($isOpens['isGroupSlug']) { ?>
											<div class="form-group">
												<div><?php echo $tagname['isGroupSlug']; ?></div>
												<input type="text" name="frm[<?php echo $kLang; ?>][slug]" placeholder="<?php echo $tagname['isGroupSlug']; ?>" class="form-control input-md" value="<?php echo $aGroupEdit['content'][$kLang]['group_slug']; ?>" autofocus />
											</div>
										<?php } ?>

										<?php if ($isOpens['isGroupDetail']) { ?>
											<div class="form-group">
												<div><?php echo $tagname['isGroupDetail']; ?></div>
												<div>
													<?php if ($isOpens['EDTNAME'] === 'ckeditor5') {
													?> <div id="editor1_<?php echo $kLang; ?>" style="min-height: 600px;"><?php echo (@$aGroupEdit['content'][$kLang]['detail']) ? @$aGroupEdit['content'][$kLang]['detail'] : '&nbsp;'; ?></div>
														<textarea name="frm[<?php echo $kLang; ?>][detail]"
															id="output1_<?php echo $kLang; ?>"
															rows="5" style="display:none; width:100%;"></textarea>
													<?php } else {
													?>
														<textarea name="frm[<?php echo $kLang; ?>][detail]" class="<?php echo ($isOpens['EDTNAME'] === 'ckeditor') ? 'ckeditor' : 'demo-summernote'; ?>" rows="5" style="width:100%;font-size: 18px;"><?php echo (@$aGroupEdit['content'][$kLang]['detail']) ? @$aGroupEdit['content'][$kLang]['detail'] : '&nbsp;'; ?></textarea>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
										<?php if ($isOpens['isGroupDetailExtra1']) { ?>
											<div class="form-group">
												<div><?php echo $tagname['isGroupDetailExtra1']; ?></div>
												<div>
													<?php if ($isOpens['EDTNAME'] === 'ckeditor5') {
													?> <div id="editor2_<?php echo $kLang; ?>" style="min-height: 600px;"><?php echo (@$aGroupEdit['content'][$kLang]['detailExtra1']) ? @$aGroupEdit['content'][$kLang]['detailExtra1'] : '&nbsp;'; ?></div>
														<textarea name="frm[<?php echo $kLang; ?>][detailExtra1]"
															id="output2_<?php echo $kLang; ?>"
															rows="5" style="display:none; width:100%;"></textarea>
													<?php } else {
													?>
														<textarea name="frm[<?php echo $kLang; ?>][detailExtra1]" class="<?php echo ($isOpens['EDTNAME'] === 'ckeditor') ? 'ckeditor' : 'demo-summernote'; ?>" rows="5" style="width:100%;font-size: 18px;"><?php echo (@$aGroupEdit['content'][$kLang]['detailExtra1']) ? @$aGroupEdit['content'][$kLang]['detailExtra1'] : '&nbsp;'; ?></textarea>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
										<?php if ($isOpens['isGroupDetailExtra2']) { ?>
											<div class="form-group">
												<div><?php echo $tagname['isGroupDetailExtra2']; ?></div>
												<div>
													<?php if ($isOpens['EDTNAME'] === 'ckeditor5') {
													?> <div id="editor3_<?php echo $kLang; ?>" style="min-height: 600px;"><?php echo (@$aGroupEdit['content'][$kLang]['detailExtra2']) ? @$aGroupEdit['content'][$kLang]['detailExtra2'] : '&nbsp;'; ?></div>
														<textarea name="frm[<?php echo $kLang; ?>][detailExtra2]"
															id="output3_<?php echo $kLang; ?>"
															rows="5" style="display:none; width:100%;"></textarea>
													<?php } else {
													?>
														<textarea name="frm[<?php echo $kLang; ?>][detailExtra2]" class="<?php echo ($isOpens['EDTNAME'] === 'ckeditor') ? 'ckeditor' : 'demo-summernote'; ?>" rows="5" style="width:100%;font-size: 18px;"><?php echo (@$aGroupEdit['content'][$kLang]['detailExtra2']) ? @$aGroupEdit['content'][$kLang]['detailExtra2'] : '&nbsp;'; ?></textarea>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
										<br clear="all" />
									</div>
								<?php } ?>

								<?php if ($isOpens['isGroupAttachPic']) { ?>
									<div id="uploadPic" class="tab-pane fade in">
										<div class="row">
											<div class="col-md-12">
												<div class="panel">
													<div class="panel-heading">
														<h3 class="panel-title "> จัดการรูปภาพแนบ </h3>
													</div>
													<div class="panel-body">
														<?php include('tab-uploads.php'); ?>
														<?php
														if ($aPictureAtt['num_rows'] > 0) {
															echo '<div class="text-main text-bold" style="font-size: 20px;margin-top: 20px;"> รูปภาพแนบทั้งหมด <span class="text-bold" style="color: #f38311e3; font-size: 20px;">(' . @$aPictureAtt['num_rows'] . ')</span> รูป</div>';
															include('tab-uploads-list.php');
														} ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</form>

<?php
if ($isOpens['EDTNAME'] == 'ckeditor' || $isOpens['EDTNAME'] == 'ckeditor5') {
	$aConfig['editor_height'] = $aArticleConfig['editorheight'];
	$aConfig['isTabLoad'] = true;
	include('include/pages_inc/editor.php');
}
?>