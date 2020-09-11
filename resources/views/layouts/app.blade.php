<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" onclick="myredirect()">
                   {{ Html::image('img/logo.png', 'back', array('style' => 'max-width: 60px; margin:auto; margin-top:0px;color:#6c757d','class'=>'arrow-back')) }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    @guest

                    @else
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Home</a>
                        </li>

                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="{{ url('/dewlcreator') }}">Create Dewl</a>-->
                        <!--</li>-->

                        <!--<li class="nav-item" >-->
                        <!--    <a class="nav-link" href="#">History</a>-->
                        <!--</li>-->
                        <!--<li class="nav-item" >-->
                        <!--    <a class="nav-link" href="{{ url('/status') }}">Status</a>-->
                        <!--</li>-->
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="{{url('/witness')}}">Witness</a>-->
                        <!--</li>-->
                        <li class="nav-item" >
                            <a class="nav-link" href="/public/transactionmanager">Deposit Stacks</a>
                        </li>
                    </ul>
                    @endguest



                    @auth


                @endauth


                <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <strong>
                                        {{ $amount  = \Illuminate\Support\Facades\DB::table('internalaccounts')->where('id','=',Auth::user()->id)->first()->balance}}
                                        Stacks
                                    </strong>
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <!--<a class="dropdown-item" href="#">-->
                                    <!--Billing Info-->
                                    <!--</a>-->
                                    <a class="dropdown-item" href="/public/myaccount">
                                    Friends
                                    </a>
                                    <hr  class="nav-bar-separator">
                                    <a class="dropdown-item"  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit(); location.replace = 'https://dewlerswebsite.mvagency.co';">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
