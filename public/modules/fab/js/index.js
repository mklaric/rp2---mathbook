$(document).ready(function () {
    $('.fab_button').mouseenter(function () {
        $(this).parent().siblings('td').children('.fab_label').show();
    });

    $('.fab_main_button').mouseenter(function () {
        $(this).parent().siblings('td').children('.fab_label').show();

        $('.fab_main_button .rotate').css('background-image',
                                          'url("/icons/edit.svg")');
        $('.fab_main_button .rotate').css( 'transform', 'rotate(0deg)');

        var b = $('.fab_button_wrapper');
        for (var i = 0; i < b.length; ++i) {
            b.eq(i).stop().fadeIn(50 + (b.length - i - 1) * 50);
            b.eq(i).children('.fab_button').stop()
                   .animate({'margin-bottom': '15px'}, (b.length - i - 1) * 50);
        }
    });

    $('.fab_button').mouseleave(function () {
        $(this).parent().siblings('td').children('.fab_label').hide();
    });

    $('.fab_main_button').mouseleave(function () {
        $(this).parent().siblings('td').children('.fab_label').hide();
    });

    $('.fab_container').mouseleave(function () {
        $('.fab_main_button .rotate').css('background-image',
                                          'url("/icons/plus.svg")');
        $('.fab_main_button .rotate').css( 'transform', 'rotate(90deg)');

        var b = $('.fab_button_wrapper');
        for (var i = 0; i < b.length; ++i) {
            b.eq(i).children('.fab_button').stop()
                   .animate({'margin-bottom': '8px'}, i * 50)
            b.eq(i).stop().fadeOut(200 + i * 40);
        }
    });
});
