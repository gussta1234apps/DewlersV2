<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dewlers</title>

{{--    <title>Dewlers</title>--}}

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
{{--    <script src="{{ asset('js/scripts.js') }}" defer></script>--}}

    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

{{--            ALERTIFY        --}}
<!-- JavaScript -->
{{--    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>--}}

{{--    <!-- CSS -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>--}}
{{--    <!-- Default theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>--}}
{{--    <!-- Semantic UI theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>--}}
{{--    <!-- Bootstrap theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>--}}

{{--    <!----}}
{{--        RTL version--}}
{{--    -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>--}}
{{--    <!-- Default theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>--}}
{{--    <!-- Semantic UI theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>--}}
{{--    <!-- Bootstrap theme -->--}}
{{--    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>--}}

    @yield('extra_links')
</head>
<body>
    <div id="app">


        <!--ain class="py-4"-->
            @yield('content')
        <!--/main-->
    </div>
</body>
</html>
