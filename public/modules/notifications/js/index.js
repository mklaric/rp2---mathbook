$(document).ready(function() {
    $('#notificationsBody').perfectScrollbar();

    var number = $('#notificationsLink .notification-counter').eq(0).html();
    if (number !== '0')
        $('#notificationsLink .notification-counter').addClass('notification-new');


    $("#notificationsLink").click(function() {
        $("#notificationContainer").fadeToggle(300);
        return false;
    });

    var w = $("#notificationsLink").width() / 2 - 1;
    $('#notificationContainer').css('right', w + 'px');

    $(document).click(function(event) { 
        if(!$(event.target).closest('#notificationContainer').length &&
           !$(event.target).is('#notificationContainer')) {
            if($('#notificationContainer').is(":visible")) {
                $('#notificationContainer').fadeOut(300);
            }
        }
    });
});
