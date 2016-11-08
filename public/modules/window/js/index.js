function Window(width = 600, height = null)
{
    this.title = null;
    this.body = null;
    this.footer = null;
    this.width = width;
    this.height = height;
    this.node = document.createElement('div');
    this.dim = true;
    this.floating = false;
}

Window.prototype._prepare = function () {
    if (this.dim) {
        var _dim = document.createElement('div');
        $(_dim).addClass('dim');
        $(this.node).append(_dim);
    }

    var _window = document.createElement('div');
    $(_window).addClass('window');

    var _windowContainer = document.createElement('div');
    $(_windowContainer).addClass('windowContainer');
    $(_window).append(_windowContainer);
    if (this.height !== null)
        _windowContainer.style.height = this.height + 'px';
    _windowContainer.style.width = this.width + 'px';

    var _windowBody = document.createElement('div');
    $(_windowBody).addClass('windowBody');

    if (this.title !== null) {
        var _windowTitleBar = document.createElement('div');
        $(_windowTitleBar).addClass('windowTitleBar');

        var _windowTitle = document.createElement('div');
        $(_windowTitle).addClass('windowTitle');
        _windowTitle.innerHTML = this.title;

        $(_windowTitleBar).append(_windowTitle);
        $(_windowContainer).append(_windowTitleBar);
    } else {
        _windowBody.style.borderTopLeftRadius = '4px';
        _windowBody.style.borderTopRightRadius = '4px';
    }

    _windowBody.innerHTML = this.body;
    $(_windowContainer).append(_windowBody);

    if (this.footer !== null) {
        var _windowFooter = document.createElement('div');
        $(_windowFooter).addClass('windowFooter');
        _windowFooter.innerHTML = this.footer;
        $(_windowContainer).append(_windowFooter);
    } else {
        _windowBody.style.borderBottomLeftRadius = '4px';
        _windowBody.style.borderBottomRightRadius = '4px';
    }

    $(this.node).append(_window);
}

Window.prototype.remove = function () {
    $(this.node).children('.window').children('.windowContainer').fadeOut(300);
    $(this.node).children('.dim').fadeOut(300);
    var t = this;
    setTimeout(function () {$(t.node).remove()}, 300);
}

Window.prototype.draw = function () {
    if ($('.window').length)
        return;
    this._prepare();

    $('body').prepend(this.node);
    $(this.node).find('.windowBody').perfectScrollbar();

    var shift = 0;
    shift += $(this.node).find('.windowTitleBar').outerHeight();
    shift += $(this.node).find('.windowFooter').outerHeight();
    if (this.height !== null) {
        var h = this.height - shift;
        $(this.node).find('.windowBody').css('max-height', h + 'px');
    }
    
    $(this.node).children('.dim').fadeIn(300);
    $(this.node).children('.window').children('.windowContainer').fadeIn(300);

    var t = this;
    $('.windowClose').click(function() {
        t.remove();
    });

    if (this.floating)
        $(document).mousedown(function(event) { 
            if(!$(event.target).closest('.windowContainer').length &&
               !$(event.target).is('.windowContainer')) {
                if($('.windowContainer').is(":visible")) {
                    t.remove();
                }
            }
        });
};
