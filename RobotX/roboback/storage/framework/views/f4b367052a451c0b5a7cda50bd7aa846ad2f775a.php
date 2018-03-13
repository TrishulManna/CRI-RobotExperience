<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'RobotRentals')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('/css/jquery-ui.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/jquery-ui.structure.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/jquery-ui.theme.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/font-awesome.min.css')); ?>" rel='stylesheet' type='text/css'>
    <link href="<?php echo e(asset('/css/fontawesome-iconpicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/vex.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/vex-theme-default.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/selectize.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/selectize.bootstrap3.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/selectize.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/datetimepicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/dropzone.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/sweetalert.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/application.css')); ?>" rel="stylesheet">

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
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <img src="<?php echo e(asset('/images/Robotrentals-rent-a-robot.jpg')); ?>" class="logo-top" alt="RobotRentals" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <?php if(!Auth::guest()): ?>
                        <li><a href="<?php echo e(asset('/projects')); ?>"><i class="fa fa-list"></i> Dashboards</a></li>
                        <li><a href="<?php echo e(asset('/behaviors')); ?>"><i class="fa fa-smile-o"></i> Behaviors</a></li>
                        <li><a href="<?php echo e(asset('/texts')); ?>"><i class="fa fa-commenting-o"></i> Texts</a></li>
                        <li><a href="<?php echo e(asset('/icons')); ?>"><i class="fa fa-info"></i> Icons</a></li>
                        <li><a href="<?php echo e(asset('/robots')); ?>"><i class="fa fa-android"></i> Robots</a></li>
                        <li><a href="<?php echo e(asset('../../robot/app/index.html?ref=robopack')); ?>"><i class="fa fa-reddit-alien"></i> Connect to Robot</a></li>
                    <?php endif; ?>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(asset('/login')); ?>">Login</a></li>
                        <li><a href="<?php echo e(asset('/register')); ?>">Register</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <!--
                            -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo e(asset('/logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="<?php echo e(asset('/logout')); ?>" method="POST" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Scripts -->
    <script src="<?php echo e(asset('/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/fontawesome-iconpicker.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/ekko-lightbox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.fancybox.pack.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.vex.combined.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/selectize.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/ladda/spin.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/ladda/ladda.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/ajax-form.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/datetimepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/tablednd.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/popup.js')); ?>"></script>

    <script>
        var host = "<?php echo e(URL::to('/')); ?>";
        var csrf_token = "<?php echo e(csrf_token()); ?>";
        Dropzone.autoDiscover = false;
    </script>

    <script src="<?php echo e(asset('/js/main.js')); ?>"></script>

    <?php echo $__env->yieldContent('javascript'); ?>

</body>
</html>
