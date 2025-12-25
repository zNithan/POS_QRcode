<?php
$keysname = REQ_get('keysname', 'post', 'str', '');
?>
<div class="modal fade" id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 90%;">
        <div class=" modal-content">
            <div class="modal-header bord-btm">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body" style="height: 70vh; /*overflow-y: auto;*/">
                <iframe src="<?php echo URL_AOWEBDATA . '/preview/preview_' . $keysname . '.php' ?>" frameborder="0" width="100%" height="100%"></iframe>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <div style="flex-grow: 1; text-align: left;">
                    <button type="button" class="btn btn-danger" onclick="window.location.reload();"><i class="fa fa-times-circle" style="font-size: 12px;"></i> Clear</button>
                </div>
                <div style="text-align: right;">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Back to edit</button>
                    <button type="submit" class="btn btn-mint" onclick="$('#form1').submit();"><i class="fa fa-save" style="font-size: 12px;"></i> Save & Publish</button>
                </div>
            </div>
        </div>
    </div>
</div>