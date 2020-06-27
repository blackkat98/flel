<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>{{ config('app.name') }} @lang('Home') | @yield('title')</title>

    <link rel="icon" href="{{ asset('img/flel.png') }}">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CMuli:400,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('home_config/css/bootstrap.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('home_config/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('home_config/css/style.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('home_config/css/custom.css') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/adminlte3/plugins/toastr/toastr.min.css') }}">
    @yield('css')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>
    <!-- HEADER -->
    <header id="header">
        <!-- NAV -->
        <div id="nav">
            <!-- Top Nav -->
            <div id="nav-top">
                <div class="container">
                    <!-- logo -->
                    <div class="nav-logo">

                        <a href="#" class="logo"><img src="{{ asset('img/flel_h.png') }}" alt=""></a>
                    </div>
                    <!-- /logo -->

                    <!-- search & aside toggle -->
                    <div class="nav-btns">
                        <!-- Authentication Links -->
                        @guest
                            <a class="btn btn-default" href="{{ route('login') }}" role="button">@lang('Login')</a>
                            <a class="btn btn-default" href="{{ route('register') }}" role="button">@lang('Register')</a>
                        @else
                            <ul>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}<span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('home-me-profile-show') }}">
                                                &nbsp;&nbsp;<i class="fa fa-folder-open"></i>
                                                &nbsp;&nbsp;@lang('Profile')
                                            </a>
                                        </div>
                                        @hasanyrole('root|admin|editor')
                                            <div>
                                                <a class="dropdown-item" href="{{ route('admin') }}">
                                                    &nbsp;&nbsp;<i class="fa fa-key"></i>
                                                    &nbsp;&nbsp;@lang('Adminstration')
                                                </a>
                                            </div>
                                        @endhasanyrole
                                        <div>
                                            <a class="dropdown-item" href="{{ route('home-statistics') }}">
                                                &nbsp;&nbsp;<i class="fa fa-tachometer"></i>
                                                &nbsp;&nbsp;@lang('Statistics')
                                            </a>
                                        </div>
                                        <div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                &nbsp;&nbsp;<i class="fa fa-power-off"></i>
                                                &nbsp;&nbsp;@lang('Logout')
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endguest

                        <button class="search-btn"><i class="fa fa-search"></i></button>
                        <button class="aside-btn">{{ app()->getLocale() }}</button>
                        <div id="nav-search">
                            <form id="js-search-form" method="post" action="{{ route('home-search') }}">
                                <input class="hidden" name="_token" value="{{ csrf_token() }}">
                                <input class="input" name="text" placeholder="@lang('Search')">
                                <button id="js-search-btn" type="button" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                            <button class="nav-close search-close">
                                <span></span>
                            </button>
                        </div>
                    </div>
                    <!-- /search & aside toggle -->
                </div>
            <!-- /Top Nav -->
            </div>
            <!-- Slide Nav -->


            <!-- Main Nav -->
            <div id="nav-bottom">
                <div class="container">
                    <!-- nav -->

                    <ul class="nav-menu">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fa fa-home"></i> @lang('Home')
                            </a>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Q&A') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($languages as $language)
                                            <li>
                                                <a href="{{ route('home-topic-list', ['language_slug' => $language->slug]) }}">
                                                    {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Words') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($languages as $language)
                                            <li>
                                                <a href="{{ route('home-word-categories-list', ['language_slug' => $language->slug]) }}"> @lang('Words') @lang('In') {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Courses') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($languages as $language)
                                            <li>
                                                <b>
                                                    <a href="{{ route('home-course-list', ['language_slug' => $language->slug]) }}">
                                                        {{ $language->name }}
                                                    </a>
                                                </b>
                                            </li>

                                            @foreach ($courses as $course)
                                                @if ($course->language_id === $language->id)
                                                    <li>
                                                        <a href="{{ route('home-course-show', ['code' => $course->code]) }}">
                                                            <i>{{ $course->name }}</i>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Test Types') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($languages as $language)
                                            <li>
                                                <b>
                                                    <a href="{{ route('home-test-type-list', ['language_slug' => $language->slug]) }}">
                                                        {{ $language->name }}
                                                    </a>
                                                </b>
                                            </li>

                                            @foreach ($test_types as $test_type)
                                                @if ($test_type->language_id == $language->id)
                                                    <li>
                                                        <a href="{{ route('home-test-type-show', ['slug' => $test_type->slug]) }}">
                                                            <i>{{ $test_type->name }}</i>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Tests') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($tests as $test)
                                            <li>
                                                <a href="{{ route('home-test-show-overall', ['type_slug' => $test->testType->slug, 'code' => $test->code]) }}">
                                                    <i>{{ $test->name }} ({{ $test->testType->name }})</i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="has-dropdown">
                            <a href="#"> @lang('Tutor Contacts') </a>
                            <div class="dropdown">
                                <div class="dropdown-body">
                                    <ul class="dropdown-list">
                                        @foreach ($languages as $language)
                                            <li>
                                                <a href="{{ route('home-tutor-list', ['language_slug' => $language->slug]) }}">
                                                    {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('home-thread-list') }}">
                                <i class="fa fa-code"></i> @lang('Threads')
                            </a>
                        </li>
                    </ul>
                    <!-- /nav -->
                </div>
            </div>
            <!-- /Main Nav -->

            <!-- Aside Nav -->
            <div id="nav-aside">
                <ul class="nav-aside-menu">
                    @lang('Select page language')
                    <br>&nbsp;
                    @foreach ($locales as $key => $value)
                        <a href="{{ route('home-locale', ['locale' => $key]) }}">
                            <h5><b style="color: #ffffff;">{{ $value }} ({{ $key }})</b></h5>
                        </a>
                    @endforeach
                </ul>
                <button class="nav-close nav-aside-close"><span></span></button>
            </div>
            <!-- /Aside Nav -->
        </div>
        <!-- /NAV -->
    </header>
    <!-- /HEADER -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            @yield('slide')
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            @yield('content')
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- FOOTER -->
    <footer id="footer">
        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="footer-bottom row">

                <div class="col-md-6 col-md-push-3 text-center">
                    <div class="footer-copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Colorlib | All Right Reserved
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('home_config/js/jquery.min.js') }}"></script>
    <script src="{{ asset('home_config/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('home_config/js/main.js') }}"></script>
    <script src="{{ asset('home_config/js/custom.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('bower_components/adminlte3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/adminlte3/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(window).on('keydown', function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            });

            $(document).on('click', '#js-search-btn', function () {
                if ($('input[name="text"]').val() === '') {
                    return;
                }

                $('#js-search-form').submit();
            });

            if ('{!! session()->get('success') !!}' !== '') {
                toastr.success('{!! session()->get('success') !!}');
            }

            if ('{!! session()->get('error') !!}' !== '') {
                toastr.error('{!! session()->get('error') !!}');
            }

            if ('{!! session()->get('warning') !!}' !== '') {
                toastr.warning('{!! session()->get('warning') !!}');
            }
            
            var form_validation_errors = {!! json_encode($errors->toArray(), JSON_HEX_TAG) !!};
            
            for (var key in form_validation_errors) {
                toastr.warning(form_validation_errors[key][0]);
            }

            var socket = io('http://localhost:6001');

            socket.on('test_socket', function (data) {
                console.log(data);
            });

            $.ajax({
                type: 'GET',
                url: '{{ route('home-noti-load-unread-ajax') }}',
                success: function (received_data) {
                    var confirm_txt = '{{ __('Confirm') }}';
                    var route = '{{ route('home-noti-redirect-read') }}';

                    for (var noti of received_data) {
                        console.log(noti);
                        var form = `
                            <form method="post" action="${route}">
                                <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                                <input class="hidden" name="id" value="${noti.id}" readonly>
                                <button type="submit" class="btn btn-default">
                                    ${confirm_txt}
                                </button>
                            </form>
                        `;

                        toastr.info(form, noti.display, {
                            timeOut: 0,
                            extendedTimeOut: 0,
                            closeButton: true
                        });
                    }
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });

            socket.on('noti_to_tutor', function (data) {
                if (parseInt('{{ Auth::check() == 1 }}') !== 1) {
                    return;
                }

                var confirm_txt = '{{ __('Confirm') }}';
                var auth_id = parseInt('{{ Auth::check() ? Auth::user()->id : 0 }}');

                if (auth_id !== parseInt(data.user_id)) {
                    return;
                }

                var route = '{{ route('home-noti-redirect-read') }}';
                var form = `
                    <form method="post" action="${route}">
                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                        <input class="hidden" name="id" value="${data.id}" readonly>
                        <button type="submit" class="btn btn-default">
                            ${confirm_txt}
                        </button>
                    </form>
                `;

                toastr.info(form, data.display, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true
                });
            });

            socket.on('noti_for_chat', function (data) {
                if (parseInt('{{ Auth::check() == 1 }}') !== 1) {
                    return;
                }

                var confirm_txt = '{{ __('Confirm') }}';
                var auth_id = parseInt('{{ Auth::check() ? Auth::user()->id : 0 }}');

                if (auth_id !== parseInt(data.user_id)) {
                    return;
                }

                var route = '{{ route('home-noti-redirect-read') }}';
                var form = `
                    <form method="post" action="${route}">
                        <input class="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                        <input class="hidden" name="id" value="${data.id}" readonly>
                        <button type="submit" class="btn btn-default">
                            ${confirm_txt}
                        </button>
                    </form>
                `;

                toastr.info(form, data.display, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true
                });
            });
        });
    </script>
    @yield('js')
</body>

</html>
