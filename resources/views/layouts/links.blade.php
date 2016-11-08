<!-- Fonts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

<!-- Styles -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="/css/style.css" type='text/css'>
<link rel="stylesheet" href="/css/sidebar.css" type='text/css'>
<link rel="stylesheet" href="/css/colors.css" type='text/css'>

<link rel="stylesheet" type="text/css" href="/modules/markdown/css/highlight.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.7/css/perfect-scrollbar.min.css">

@if (Auth::check())
<link rel="stylesheet" type="text/css" href="/modules/notifications/css/style.css">
@endif

@if (isset($modules))
    @foreach($modules as $module)
        @if (File::exists(public_path() . '/modules/' . $module . '/css/style.css'))
<link rel="stylesheet" type="text/css" href="/modules/{{ $module }}/css/style.css">
        @endif
    @endforeach
@endif


@if (isset($links))
    @foreach($links as $link)
<link rel="stylesheet" type="text/css" href="{{ $link }}">
    @endforeach
@endif
