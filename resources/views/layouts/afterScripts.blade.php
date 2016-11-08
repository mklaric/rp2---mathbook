<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="/modules/markdown/js/marked.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js"></script>

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>

<script src="/js/dates.js"></script>
<script src="d3.min.js?v=3.2.8"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.7/js/min/perfect-scrollbar.jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
function selectSidebarLink() {
    var pathname = window.location.pathname;
    var index = pathname.split('/')[3];
    if (index === undefined)
        pathname = pathname + '/home';

    $s = $('#sidebar-wrapper li a[href="' + pathname + '"]');
    $s.addClass('sidebarLinkActive');
    $s.click(function() {
        return false;
    });
}

function mark() {
    $('.markdown').each(function () {
        $(this).html(marked($(this).html()));
    });
    hljs.initHighlighting.called = false;
    hljs.initHighlighting();
    MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
}

$(document).ready(function() {
    $('#page-content-wrapper').perfectScrollbar();

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        @if (Auth::check() || isset($page))
            $("#wrapper").toggleClass("toggled");
        @endif
    });

    mark();
    selectSidebarLink();
});
</script>

@if (Auth::check() && isset($page) && Auth::user()->hasAnyRole(['admin', $page->id . '.admin']))
<script src="/js/sidebar.js"></script>
@endif

<script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
    jax: ["input/TeX", "output/HTML-CSS"],
    tex2jax: {
      inlineMath: [ ['$','$'], ["\\(","\\)"] ],
      displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
      processEscapes: true
    },
    "HTML-CSS": { availableFonts: ["TeX"] }
  });
</script>

@if (Auth::check())
<script src="/modules/notifications/js/index.js"></script>
@endif

@if (isset($modules))
    @foreach($modules as $module)
        @if (File::exists(public_path() . "/modules/" . $module . "/js/index.js"))
<script src="/modules/{{ $module }}/js/index.js"></script>
        @endif
    @endforeach
@endif

@if (isset($scripts))
    @foreach($scripts as $script)
<script src="{{ $script }}"></script>
    @endforeach
@endif
