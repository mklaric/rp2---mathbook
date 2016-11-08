
function parse(n, d) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    if (n < 2 * 60 * 1000) {
        return '1 minute ago';
    }
    if (n < 60 * 60 * 1000) {
        var h = Math.floor(n / (60 * 1000));
        h += ' minutes ago';
        return h;
    }
    if (n < 2 * 60 * 60 * 1000) {
        return 'an hour ago';
    }
    if (n < 24 * 60 * 60 * 1000) {
        var h = Math.floor(n / (60 * 60 * 1000));
        h += ' hours ago';
        return h;
    }

    if (n < 2 *  24 * 60 * 60 * 1000) {
        var h = 'Yesterday at ' + d.getHours() + ':' + d.getMinutes();
        return h;
    }

    var h = months[d.getMonth()] + ' ' + d.getDate() + ' at ';
    h += d.getHours() + ':' + d.getMinutes();
    return h;
}

function format_date()
{
    $('.notification-date').each(function () {
        var s = $(this).attr('datetime');
        var year = s.substr(0, 4);
        var month = s.substr(5, 2);
        var day = s.substr(8, 2);
        var hour = s.substr(11, 2);
        var minute = s.substr(14, 2);
        var seconds = s.substr(17, 2);

        var d = new Date(Date.UTC(year, month - 1, day, hour, minute, seconds));
        var n = new Date(Date.now());

        var diff = n.getTime() - d.getTime();
        var out = parse(diff, d);

        $(this).html(out);
    });
}

$(document).ready(function () {
    format_date();
    setInterval(format_date, 60000);
});
