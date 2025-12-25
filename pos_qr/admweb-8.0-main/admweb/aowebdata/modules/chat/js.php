<script>
    var ct = <?php echo json_encode(isset($ct) ? $ct : null); ?>;
    var oid = <?php echo json_encode(isset($oid) ? (int)$oid : null); ?>;
    var uid = <?php echo json_encode(isset($uid) ? (int)$uid : null); ?>;
    var ckGC = <?php echo json_encode(isset($ckGC) ? $ckGC : null); ?>;
    var ckUC = <?php echo json_encode(isset($ckUC) ? $ckUC : null); ?>;
    var keysname = <?php echo json_encode(isset($keysname) ? $keysname : null); ?>;
    var interval = <?php echo json_encode(GlobalConfig_get('interval', 5) * 1000); ?>;
    var lMsgGroup = "";
    var lMsgUser = "";
    var prevGroupCount = 0;
    var prevUserCount = 0;

    $('#msg').on('input keydown', function(event) {
        $(this).css('height', 'auto');
        $(this).css('height', this.scrollHeight + 'px');
        $('#submitBtn').prop('disabled', $(this).val().trim() === '');
        if (event.type === 'keydown' && event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            if ($(this).val().trim() !== "") {
                $('#formChatGroup').submit();
                $('#formChatUser').submit();
            }
        }
    });

    $('.chat-emoticons').on('click', function(e) {
        var imgTag = $(this).find('.chat-emoticons-image').prop('outerHTML');
        $.ajax({
            url: "doAjax.php?module=chat&mp=write_chat_group",
            method: "POST",
            data: {
                oid: oid,
                keysname: keysname,
                ac: $('#ac').val(),
                msg: imgTag
            },
            dataType: 'html',
            success: function(data) {
                fetchChatGroup();
                fetchChatList();
                $('#demo-default-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });

    $('.chat-emoticons').on('click', function(e) {
        var imgTag = $(this).find('.chat-emoticons-image').prop('outerHTML');
        $.ajax({
            url: "doAjax.php?module=chat&mp=write_chat_user",
            method: "POST",
            data: {
                uid: uid,
                oid: oid,
                ac: $('#ac').val(),
                msg: imgTag
            },
            dataType: 'html',
            success: function(data) {
                fetchChatUser();
                fetchChatList();
                $('#demo-default-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });

    $('#formChatGroup').on('submit', function(e) {
        e.preventDefault();
        var formData = $('#formChatGroup').serializeArray();
        $.ajax({
            url: "doAjax.php?module=chat&mp=write_chat_group",
            method: "POST",
            data: {
                oid: oid,
                keysname: keysname,
                ac: $('#ac').val(),
                msg: $('#msg').val()
            },
            dataType: 'html',
            success: function(data) {
                fetchChatGroup();
                fetchChatList();
                $('#msg').val('');
                $('#msg').css('height', 'auto');
                $('#submitBtn').prop('disabled', true);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });

    $('#formChatUser').on('submit', function(e) {
        e.preventDefault();
        var formData = $('#formChatUser').serializeArray();
        $.ajax({
            url: "doAjax.php?module=chat&mp=write_chat_user",
            method: "POST",
            data: {
                uid: uid,
                oid: oid,
                ac: $('#ac').val(),
                msg: $('#msg').val()
            },
            dataType: 'html',
            success: function(data) {
                fetchChatUser();
                fetchChatList();
                $('#msg').val('');
                $('#msg').css('height', 'auto');
                $('#submitBtn').prop('disabled', true);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });

    function fetchChatGroup() {
        $.ajax({
            url: 'doAjax.php?module=chat&mp=read_chat_group',
            method: 'POST',
            data: {
                oid: oid,
                keysname: keysname
            },
            dataType: 'html',
            success: function(data) {
                var chatGroup = $("#chat-data-group").html(data);
                var currentGroupCount = chatGroup.children().length;
                var nlMsgGroup = chatGroup.children().last().text();
                if (nlMsgGroup !== lMsgGroup || currentGroupCount !== prevGroupCount) {
                    lMsgGroup = nlMsgGroup;
                    prevGroupCount = currentGroupCount;
                    scrollToBottom();
                }
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    function fetchChatUser() {
        $.ajax({
            url: 'doAjax.php?module=chat&mp=read_chat_user',
            method: 'POST',
            data: {
                uid: uid,
                oid: oid
            },
            dataType: 'html',
            success: function(data) {
                var chatUser = $("#chat-data-user").html(data);
                var currentUserCount = chatUser.children().length;
                var nlMsgUser = chatUser.children().last().text();
                if (nlMsgUser !== lMsgUser || currentUserCount !== prevUserCount) {
                    lMsgUser = nlMsgUser;
                    prevUserCount = currentUserCount;
                    scrollToBottom();
                }
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    function fetchChatList() {
        $.ajax({
            url: "doAjax.php?module=chat&mp=read_chat_list",
            method: "POST",
            data: {
                uid: uid,
                oid: oid,
                keysname: keysname,
                ckGC: ckGC,
                ckUC: ckUC
            },
            dataType: "html",
            success: function(data) {
                $("#chat-data-list").html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }
    if (ct === 'group_chat' ? true : false) {
        fetchChatGroup();
        fetchChatList();
        setInterval(fetchChatGroup, interval);
        setInterval(fetchChatList, interval);
    }
    if (ct === 'user_chat' ? true : false) {
        fetchChatUser();
        fetchChatList();
        setInterval(fetchChatUser, interval);
        setInterval(fetchChatList, interval);
    }
</script>