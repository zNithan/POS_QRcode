<script>
    <?php
    $statusPreview = GlobalConfig_get('previewonoff');
    if ($statusPreview == '1') {

        if ($_REQUEST['mp'] == 'articles' || $_REQUEST['mp'] == 'config') {
            $module = REQ_get('module', 'get', 'str', '');
            $keysname = REQ_get('keysname', 'get', 'str', '');
            $keyname = file_exists(PATH_AOWEBDATA . '/preview/preview_' . $keysname . '.php') ? $keysname : 'aotemplate';
            $_SESSION['previewKeysname'] = $keysname; ?>

            const module = "<?php echo $module; ?>";
            const keysname = "<?php echo $keysname; ?>";
            const fname = "<?php echo URL_AOWEBDATA . '/preview/preview_' . $keyname . '.php'; ?>";

            function ajaxRequest(url, data, success) {
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    success: success
                });
            }

            function formClearSession() {
                var formData = $('#form1').serialize();
                ajaxRequest("doAjax.php?module=" + module + "&mp=form_clear", formData);
            }

            formClearSession();

            ajaxRequest("doAjax.php?module=" + module + "&mp=form_modal", {
                keysname: keysname
            }, function(modal) {
                $('#form1').after(modal);
            });

            $('#add-and-publish').before(`
        <button class="btn btn-pink" id="preview-publish" style="font-size: 24px; font-family: db_ozone_xregular; margin-right: 10px;">
            <i class="fa fa-eye" style="font-size: 18px;"></i> Preview
        </button>
        `);

            $('#preview-publish').click(function(e) {
                e.preventDefault();
                var formData = $('#form1').serialize();
                ajaxRequest("doAjax.php?module=" + module + "&mp=form_preview", formData, function() {
                    $('#demo-default-modal iframe').attr('src', fname);
                    $('#demo-default-modal').modal('show');
                });
            });
    <?php }
    } ?>
</script>