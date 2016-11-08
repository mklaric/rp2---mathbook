$(document).ready(function () {
    var _editMode = false;
    var page = window.location.pathname.split('/')[2];

    function editModeSetup() {
        $(".sortable").sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                var token = $(this).children('input').val();

                $.ajax({
                    data: {_token :token, data},
                    type: 'PUT',
                    url: '/pages/' + page + '/settings/sidebar/edit',
                    success: function (data) {
                        console.log(data.status + ': ' + data.message);
                    },
                    error: function (data) {
                        console.log('error: sidebar edit ajax request failed');
                    }
                });

                $('.sortable li').each(function (index) {
                    var _id = $(this).parent().attr('id').slice(0, -1);
                    $(this).attr('id', _id + '_' + (index + 1));
                });
            }
        });
        $(".sortable").disableSelection();
    }

    function editModeOn() {
        $(".sortable li a").css('cursor', 'move');
        $(".sortable").sortable('enable');
    }

    function editModeOff() {
        $(".sortable li a").css('cursor', 'pointer');
        $(".sortable").sortable('disable');
    }

    function editModeToggle() {
        if (_editMode)
            editModeOn();
        else
            editModeOff();
    }

    editModeSetup();
    editModeOff();

    $('#editSidebarLinks').click(function () {
        $(this).parent().toggleClass('editSidebarLinksActive');
        $('.sortable li').toggleClass('moveableLink');
        _editMode = !_editMode;
        editModeToggle();
        if (_editMode)
            $(this).children('span').html('Finish');
        else
            $(this).children('span').html('Edit Sidebar');
        return false;
    });
});
