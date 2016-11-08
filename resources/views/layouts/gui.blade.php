<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (isset($name))
        <title>{{ $name }}</title> 
    @else
        <title>Mathbook</title>
    @endif

    @include("layouts.links")
    @include("layouts.beforeScripts")
</head>
<body id="app-layout">
    @if (Auth::check() || isset($page))
        <div id="wrapper">
    @else
        <div id="wrapper" class="toggled">
    @endif

        @include("layouts.sidebar")
        @include("layouts.navbar")

        <div id="page-content-wrapper" class="content-container">
            @include('layouts.flash')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include("layouts.fab")
    @include("layouts.afterScripts")
</body>
</html>
