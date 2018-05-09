<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RobotRentals') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery-ui.theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel='stylesheet' type='text/css'>
    <link href="{{ asset('/css/fontawesome-iconpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/vex.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/vex-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/selectize.bootstrap3.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/application.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/images/Robotrentals-rent-a-robot.jpg') }}" class="logo-top" alt="RobotRentals" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li><a href="{{ asset('/projects') }}"><i class="fa fa-list"></i> Dashboards</a></li>
                        <li><a href="{{ asset('/behaviors') }}"><i class="fa fa-smile-o"></i> Behaviors</a></li>
                        <li><a href="{{ asset('/texts') }}"><i class="fa fa-commenting-o"></i> Texts</a></li>
                        <li><a href="{{ asset('/icons') }}"><i class="fa fa-info"></i> Icons</a></li>
                        <li><a href="{{ asset('/robots') }}"><i class="fa fa-android"></i> Robots</a></li>
                        @if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2)
                        <li><a href="{{ asset('/users')  }}"><i class="fa fa-user"></i> Users</a></li>
                        @endif
                        <li><a href="{{ asset('../../robot/app/index.html?ref=robopack') }}"><i class="fa fa-reddit-alien"></i> Connect to Robot</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ asset('/login') }}">Login</a></li>
                        <li><a href="{{ asset('/register') }}">Register</a></li>
                        <!-- added to refer to requestform -->
                        <li><a href="{{ asset('/requestform') }}">Request</a></li>
                    @else
                        <li class="dropdown">
                            <!--
                            -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    @if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2)
                                    <a href="{{ asset('/requestoverview') }}">Request Overview</a>
                                    @endif
                                    <a href="{{ asset('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ asset('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/fontawesome-iconpicker.js') }}"></script>
    <script src="{{ asset('/js/ekko-lightbox.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('/js/jquery.vex.combined.min.js') }}"></script>
    <script src="{{ asset('/js/selectize.min.js') }}"></script>
    <script src="{{ asset('/js/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('/js/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('/js/ajax-form.js') }}"></script>
    <script src="{{ asset('/js/datetimepicker.js') }}"></script>
    <script src="{{ asset('/js/dropzone.js') }}"></script>
    <script src="{{ asset('/js/tablednd.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/popup.js') }}"></script>

    <script>
        var host = "{{URL::to('/')}}";
        var csrf_token = "{{ csrf_token() }}";
        Dropzone.autoDiscover = false;
    </script>

    <script src="{{ asset('/js/main.js') }}"></script>

    @yield('javascript')

</body>
</html>
