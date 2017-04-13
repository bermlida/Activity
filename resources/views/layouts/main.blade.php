<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>精進之門 - 佛教活動平台</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/modern-business.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('style')

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">精進之門</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('visit::activities') }}">找活動</a></li>
                    <li><a href="{{ route('visit::organizers') }}">找主辦單位</a></li>
                    @if(Auth::guest())
                        <li><a href="{{ url('/login') }}">登入</a></li>
                        <li><a href="{{ url('/register') }}">註冊</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                會員功能
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('account::setting') }}">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                    帳戶設定
                                </a></li>
                                <li><a href="{{ route('account::info') }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    基本資料
                                </a></li>
                                @if (Auth::user()->role_id == '1')
                                    <li><a href="{{ route('participate::record::list') }}">
                                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                                        參加的活動
                                    </a></li>
                                @elseif (Auth::user()->role_id == '2')
                                    <li><a href="{{ route('organise::activity::list') }}">
                                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                                        舉辦的活動
                                    </a></li>
                                @endif
{{--
                                
                                <li><a href="portfolio-item.html">Single Portfolio Item</a></li>
--}}
                                <li><a href="{{ url('/logout') }}">
                                    <i class="fa fa-btn fa-sign-out"></i>
                                    登出
                                </a></li>
                            </ul>
                        </li>
                    @endif
{{--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="blog-home-1.html">Blog Home 1</a>
                            </li>
                            <li>
                                <a href="blog-home-2.html">Blog Home 2</a>
                            </li>
                            <li>
                                <a href="blog-post.html">Blog Post</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other Pages <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="full-width.html">Full Width Page</a>
                            </li>
                            <li>
                                <a href="sidebar.html">Sidebar Page</a>
                            </li>
                            <li>
                                <a href="faq.html">FAQ</a>
                            </li>
                            <li>
                                <a href="404.html">404</a>
                            </li>
                            <li>
                                <a href="pricing.html">Pricing Table</a>
                            </li>
                        </ul>
                    </li>
--}}
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
    @yield('content')
    
    <!-- jQuery Javascript -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('bower_components/jquery/dist/jquery.slim.min.js') }}"></script> --}}

    <!-- Bootstrap JavaScript -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

    @yield('script')

</body>

</html>
