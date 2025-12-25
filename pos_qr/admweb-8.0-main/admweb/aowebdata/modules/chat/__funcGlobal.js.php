var id = <?php echo login_logout::getAdminId(); ?>;
var interval = <?php echo GlobalConfig_get('interval', 5) * 1000; ?>;
var notify = '<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false" id="notify-chat1"><i class="demo-pli-bell"></i></a><div class="dropdown-menu dropdown-menu-md dropdown-menu-right" id="notify-chat2"></div></li>';

$('#online-top').before(notify);

$('.side-left-online').each(function(){
    var relUser_id = $(this).attr('relUser_id');
    if(relUser_id != id){
        $(this).append('<span class="label label-danger btn-chat" relUser_id="'+relUser_id+'" style="font-size:60%; cursor: pointer;">Chat&nbsp;<i class="fa fa-comments"></i></span>');
    }
});

$('.btn-chat').click(function(){
    var relUser_id = $(this).attr('relUser_id');
    var chatUrl = '<?php echo _admin_buil_link('index.php?module='._MODULE_.'&mp=chat_board&ct=user_chat'); ?>&user_id='+relUser_id;
    window.location.href = chatUrl;
});

function notifyChat() {
    $.ajax({
        url: "doAjax.php?module=chat&mp=read_notif_chat",
        method: "POST",
        data: {
            id: id
        },
        dataType: 'html',
        success: function (data) {
            $('#notify-chat2').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}

function fetchNotify() {
    $.ajax({
        url: "doAjax.php?module=chat&mp=read_notif",
        method: "POST",
        data: {
            id: id
        },
        dataType: 'html',
        success: function (data) {
            $('#notify-chat1').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}

fetchNotify();
setInterval(fetchNotify, interval);

$('#notify-chat1').click(function(){
    notifyChat();
});