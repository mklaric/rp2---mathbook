function textareaExpand (t) {
    var minRows = t.getAttribute('data_min_rows') | 0, rows;
    t.rows = minRows;
    console.log(t.scrollHeight, t.baseScrollHeight);
    rows = Math.ceil((t.scrollHeight - t.baseScrollHeight) / 17);
    t.rows = minRows + rows;
}

function setupStatic(formHTML, nameVal, linkVal) {
    $(document).on('input.textarea', '.autoExpand', function() {
        textareaExpand(this);
    });

    var pathname = window.location.pathname;
    var _page = pathname.split('/')[2];
    var index = pathname.split('/')[3];
    var hyperlink = $('.sidebar-nav ul a[href="' + pathname + '"]');

    var icons = [
        'fa-area-chart',
        'fa-bar-chart',
        'fa-bolt',
        'fa-book',
        'fa-bookmark',
        'fa-briefcase',
        'fa-bug',
        'fa-building',
        'fa-calculator',
        'fa-calendar-plus-o',
        'fa-camera',
        'fa-certificate',
        'fa-check',
        'fa-circle',
        'fa-circle-o',
        'fa-clock-o',
        'fa-clone',
        'fa-cloud',
        'fa-cloud-download',
        'fa-cloud-upload',
        'fa-code',
        'fa-code-fork',
        'fa-cog',
        'fa-cogs',
        'fa-comment',
        'fa-cube',
        'fa-database',
        'fa-desktop',
        'fa-dot-circle-o',
        'fa-download',
        'fa-ellipsis-h',
        'fa-ellipsis-v',
        'fa-envelope',
        'fa-eraser',
        'fa-exchange',
        'fa-exclamation-triangle',
        'fa-external-link',
        'fa-fax',
        'fa-feed',
        'fa-flag',
        'fa-flask',
        'fa-folder',
        'fa-folder-open',
        'fa-glass',
        'fa-globe',
        'fa-graduation-cap',
        'fa-hdd-o',
        'fa-heart',
        'fa-history',
        'fa-home',
        'fa-inbox',
        'fa-info-circle',
        'fa-key',
        'fa-laptop',
        'fa-line-chart',
        'fa-location-arrow',
        'fa-lock',
        'fa-magnet',
        'fa-map-o',
        'fa-map-marker',
        'fa-minus-circle',
        'fa-mouse-pointer',
        'fa-music',
        'fa-paper-plane',
        'fa-pencil',
        'fa-phone',
        'fa-pie-chart',
        'fa-plane',
        'fa-plug',
        'fa-plus-circle',
        'fa-power-off',
        'fa-print',
        'fa-quote-right',
        'fa-random',
        'fa-refresh',
        'fa-rss',
        'fa-search',
        'fa-server',
        'fa-shield',
        'fa-signal',
        'fa-sort',
        'fa-star',
        'fa-star-half-o',
        'fa-star-o',
        'fa-sticky-note',
        'fa-suitcase',
        'fa-tag',
        'fa-tags',
        'fa-tasks',
        'fa-television',
        'fa-terminal',
        'fa-thumb-tack',
        'fa-times',
        'fa-tree',
        'fa-trophy',
        'fa-university',
        'fa-unlock-alt',
        'fa-upload',
        'fa-user',
        'fa-wrench',
    ];

    var w;
    $("#edit").click(function() {
        w = new Window(800, 500);

        var content = $('.staticPageContent').attr('content');
        var _content = content;

        var body = document.createElement('div');

        var _text = document.createElement('textarea');
        $(_text).attr('data_min_rows', '10');
        _text.spellcheck = false;
        _text.className = 'staticPageEdit autoExpand';
        _text.placeholder = 'Content';
        _text.innerHTML = content;

        $(body).append(_text);
        w.body = body.innerHTML;

        var footer = document.createElement('div');
        var _title = document.createElement('div');
        _title.style.lineHeight = '48px';
        _title.style.float = 'left';
        _title.innerHTML = 'Edit static page';

        var _button = document.createElement('button');
        _button.style.margin = '8px';
        _button.style.width = '80px';
        _button.innerHTML = 'Save';
        $(_button).addClass('btn btn-default btn-sm btn-success pull-right windowSave');
        $(_button).append(formHTML);

        $(footer).append(_title);
        $(footer).append(_button);

        var _button = document.createElement('button');
        _button.style.margin = '8px';
        _button.style.width = '80px';
        _button.innerHTML = 'Close';
        $(_button).addClass('btn btn-default btn-sm btn-danger pull-right windowClose');

        $(footer).append(_button);
        w.footer = footer.innerHTML;

        w.draw();
        $('.autoExpand').each(function () {
            var savedValue = this.value;
            this.value = '';
            this.baseScrollHeight = this.scrollHeight;
            this.value = savedValue;
            textareaExpand(this);
        });

        $('.windowSave').mousedown(function () {
            content = $('.staticPageEdit').val();
            if (content === $('.staticPageContent').attr('content')) {
                $('.windowClose').click();
                return false;
            }

            var token = $(this).children('input').val();
            $.ajax({
                data: {_token :token, content},
                type: 'PUT',
                url: pathname,
                success: function (data) {
                    console.log(data.status + ': ' + data.message);
                    if (data.status !== 'success')
                        return false;
                    $('.staticPageContent').attr('content', content);
                    $('.staticPageContent').html(content);

                    $('.staticPageContent').each(function () {
                        $(this).html(marked($(this).html()));
                    });
                    hljs.initHighlighting.called = false;
                    hljs.initHighlighting();
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, '.staticPageContent']);
                },
                error: function (data) {
                    console.log('error: Static page content edit ajax request failed');
                    return false;
                }
            });
            $('.windowClose').click();
        });

        return false;
    });

    $("#preferences").click(function() {
        w = new Window(400);
        w.floating = false;

        var body = document.createElement('div');
        var _form = document.createElement('div');
        _form.className = 'form-horizontal';

        var _row = document.createElement('div');
        _row.className = 'form-group';

        var _label = document.createElement('label');
        _label.className = 'col-md-2 control-label';
        _label.innerHTML = 'Name';

        var _div = document.createElement('div');
        _div.className = 'col-md-10';

        var _input = document.createElement('input');
        _input.type = 'text';
        _input.className = 'form-control input-name';
        _input.placeholder = 'Name';
        _input.required = true;
        $(_input).attr('value', nameVal);

        $(_div).append(_input);
        $(_row).append(_label);
        $(_row).append(_div);

        $(_form).append(_row);

        var _row = document.createElement('div');
        _row.className = 'form-group';

        var _label = document.createElement('label');
        _label.className = 'col-md-2 control-label';
        _label.innerHTML = 'Link';

        var _div = document.createElement('div');
        _div.className = 'col-md-10';

        var _input = document.createElement('input');
        _input.type = 'text';
        _input.className = 'form-control input-link';
        _input.placeholder = 'Link';
        _input.required = true;
        $(_input).attr('value', linkVal);

        $(_div).append(_input);
        $(_row).append(_label);
        $(_row).append(_div);

        $(_form).append(_row);

        var _button = document.createElement('button');
        _button.className = 'btn btn-default btn-sm btn-success pull-right windowSave';
        _button.style.margin = '8px';
        _button.style.width = '80px';
        _button.innerHTML = 'Save';
        $(_button).append(formHTML);

        $(_form).append(_button);

        var _button = document.createElement('button');
        _button.className = 'btn btn-default btn-sm btn-danger pull-right windowClose';
        _button.style.margin = '8px';
        _button.style.width = '80px';
        _button.innerHTML = 'Close';

        $(_form).append(_button);
        $(body).append(_form);

        w.body = body.innerHTML;
        w.draw();

        $('.windowSave').mousedown(function () {
            var _linkVal = $('.input-link').val();
            var _nameVal = $('.input-name').val();

            if (linkVal === _linkVal && nameVal === _nameVal) {
                $('.windowClose').click();
                return false;
            }

            var name = _nameVal;
            var link = _linkVal;

            var token = $(this).children('input').val();
            $.ajax({
                data: {_token :token, name, link},
                type: 'PUT',
                url: pathname,
                success: function (data) {
                    console.log(data.status + ': ' + data.message);
                    if (data.status !== 'success')
                        return false;
                    var changed = linkVal !== _linkVal;
                    linkVal = _linkVal;
                    nameVal = _nameVal;
                    hyperlink.children('span').html(nameVal);
                    hyperlink.attr('href', linkVal);
                    if (changed)
                        window.location.replace('/pages/' + _page + '/' + linkVal);
                },
                error: function (data) {
                    console.log('error: Static page icon edit ajax request failed');
                    return false;
                }
            });
            $('.windowClose').click();
        });

        return false;
    });

$("#changeIcon").click(function() {
        w = new Window(360);
        w.floating = false;

        var body = document.createElement('div');

        var _table = document.createElement('table');
        _table.className = 'iconpickerItems';

        for (i = 0; i < icons.length; ++i) {
            if (i % 10 === 0) {
                if (_tr !== undefined)
                    $(_table).append(_tr);
                var _tr = document.createElement('tr');
            }

            var _td = document.createElement('td');
            var _icon = document.createElement('i');
            _icon.className = 'fa ' + icons[i];
            _td.className = 'iconpickerItem';
            _td.title = icons[i];

            $(_td).append(_icon);
            $(_tr).append(_td);

            if (i === icons.length - 1)
                $(_table).append(_tr);
        }

        $(body).append(_table);
        $(body).append('<br>');

        var _button = document.createElement('button');
        _button.className = 'btn btn-default btn-sm btn-success pull-right windowSave';
        _button.style.margin = '8px';
        _button.style.width = '80px';
        _button.innerHTML = 'Save';
        $(_button).append(formHTML);

        $(body).append(_button);

        var _button_close = document.createElement('button');
        _button_close.className = 'btn btn-default btn-sm btn-danger pull-right windowClose';
        _button_close.style.margin = '8px';
        _button_close.style.width = '80px';
        _button_close.innerHTML = 'Close';

        $(body).append(_button_close);

        w.body = body.innerHTML;
        w.draw();

        var classes = hyperlink.children('i').attr('class').split(' ');
        for (var i = 0; i < classes.length; ++i)
            if ($.inArray(classes[i], icons) > -1) {
                var icon = classes[i];
                break;
            }
        var _icon = icon;

        $('.iconpickerItem[title="' + icon + '"]').addClass('iconpickerItemSelected blue');

        $('.iconpickerItem').mousedown(function () {
            $('.iconpickerItem').removeClass('iconpickerItemSelected blue');
            $(this).addClass('iconpickerItemSelected blue');
            _icon = $(this).attr('title');
            hyperlink.children('i').removeClass();
            hyperlink.children('i').addClass('fa fa-btn ' + _icon + ' icon');
        });

        $('.windowSave').mousedown(function () {
            if (icon === _icon) {
                $('.windowClose').click();
                return false;
            }

            var token = $(this).children('input').val();
            var __icon = icon;
            icon = _icon;
            $.ajax({
                data: {_token :token, icon},
                type: 'PUT',
                url: pathname,
                success: function (data) {
                    console.log(data.status + ': ' + data.message);
                    if (data.status !== 'success')
                        return false;
                },
                error: function (data) {
                    console.log('error: Static page icon edit ajax request failed');
                    icon = __icon;
                    return false;
                }
            });
            $('.windowClose').click();
        });

        $('.windowClose').mousedown(function () {
            hyperlink.children('i').removeClass();
            hyperlink.children('i').addClass('fa fa-btn ' + icon + ' fab_icon');
            $('#changeIcon i').removeClass();
            $('#changeIcon i').addClass('fa fa-btn ' + icon + ' fab_icon');
        });
        return false;
    });
}
