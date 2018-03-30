<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="/css/mdb.min.css" rel="stylesheet">

    <link href="/css/jquery.auto-complete.css" rel="stylesheet">

    <!-- Your custom styles (optional) -->
    <link href="/css/style.css" rel="stylesheet">
    

    <!-- JQuery -->
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.auto-complete.min.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class='fixed-sn mdb-skin'>

<header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed custom-scrollbar">

        <!-- Logo -->
        <li style='border-bottom:1px solid #777; margin-bottom:30px;'>
            <div class="logo-wrapper waves-light" style='min-height:100px;'>
                <a href="/"><img src="/img/logo.png" class="img-fluid flex-center logo"></a>
            </div>
        </li>
        <!--/. Logo -->


        <!--Search Form-->
        <!--li>
            <form class="search-form" role="search">
                <div class="form-group waves-light">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </form>
        </li-->
        <!--/.Search Form-->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
            <?php
                $currentSection = MenuHelp::getCurrentSection();
            ?>
            @foreach (MenuHelp::getSideMenu() as $item)
                @if ($item->url == '/admin' && !Auth::user()->admin)
                    @continue
                @endif

                @if ($item->url == '/myemployees' && !count(Auth::user()->apprantices))
                    @continue
                @endif

                <li>
                    <a @if (!count($item->children)) href='{{ $item->url }}' @endif class="waves-effect @if (count($item->children)) collapsible-header arrow-r @endif @if (MenuHelp::isSubsectionActive($item->id) || $currentSection->id==$item->id) active @endif"><i class="fa {{ $item->icon }}"></i> @lang('messages.'.$item->codename) @if (count($item->children)) <i class="fa fa-angle-down rotate-icon"></i>@endif</a>
                    @if (count($item->children))
                        <div class="collapsible-body">
                            <ul>
                            @foreach ($item->children as $subitem)
                                <li><a href="{{ $subitem->url }}" class="waves-effect @if ($currentSection->id == $subitem->id) active @endif">@lang('messages.'.$subitem->codename)</a></li>
                            @endforeach                               
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
            </ul>
        </li>
        <!--/. Side navigation links -->

    </ul>
    <!--/. Sidebar navigation -->

    <!--Navbar-->
    <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

        <!-- SideNav slide-out button -->
        <div class="pull-left">
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
        </div>

        <!-- Breadcrumb-->
        <div class="breadcrumb-dn">
            <!--p>Breadcrumb or page title</p-->
        </div>

        <ul class="nav navbar-nav pull-right">
            <li class="nav-item ">
                <a href='/support' class="nav-link"><i class="fa fa-comments-o"></i> <span class="hidden-sm-down">@lang('messages.Support')</span></a>
            </li>
            @if (Auth::check())
            <li class="nav-item ">
                <a href='/profile' class="nav-link"><i class="fa fa-user"></i> <span class="hidden-sm-down">{{ Auth::user()->name }}</span></a>
            </li>
            <li class="nav-item ">
                <a href='{{ url('/logout') }}' class="nav-link"><i class="fa fa-power-off"></i> <span class="hidden-sm-down">@lang('messages.Logout')</span></a>
            </li>
            @endif

            <!--li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Profile</a>
                <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li-->
        </ul>

    </nav>
    <!--/.Navbar-->

</header>
<!--/Double navigation-->

<!--Main layout-->
<main>
    <div class="container-fluid">

        @yield('content')

    </div>
</main>
<!--/Main layout-->

        <!--Footer-->
        <footer class="page-footer center-on-small-only">

            <!--Footer Links-->
            <div class="container-fluid wow fadeIn" data-wow-delay="0.1s" data-wow-duration='1s'>
                <div class="row">

                    <!--First column-->
                    <div class="col-md-6 offset-md-1">
                        <h5 class="title">@lang('messages.AboutSystemTitle')</h5>
                        @lang('messages.AboutSystemText')
                    </div>
                    <!--/.First column-->

                </div>
            </div>
            <!--/.Footer Links-->

            <!--Copyright-->
            <div class="footer-copyright">
                <div class="container-fluid wow fadeInUp">
                    © 2016-{{ date("Y") }} Copyright: <a href="http://tsconsulting.ru/"> Компания «Техносерв Консалтинг» </a>
                </div>
            </div>
            <!--/.Copyright-->

        </footer>
        <!--/.Footer-->

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/js/tether.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/js/mdb.min.js"></script>

    <script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>

    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->

    <!-- JS code from developers -->
    <script type="text/javascript" src="/js/common.js"></script>


</body>
</html>
