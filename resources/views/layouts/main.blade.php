<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>精進之門 - 佛教活動平台</title>

    @include('layouts.style')

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
                    <li><a href="{{ url('/activities') }}">找活動</a></li>
                    <li><a href="{{ url('/organizers') }}">找主辦單位</a></li>
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
                                <li><a href="{{ url('/account/info') }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    帳戶資訊
                                </a></li>
                                @if (Auth::user()->role_id == '1')
                                    <li><a href="{{ url('/participate/activities') }}">
                                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                                        參加的活動
                                    </a></li>
                                @elseif (Auth::user()->role_id == '2')
                                    <li><a href="{{ url('/organise/activities') }}">
                                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                                        舉辦的活動
                                    </a></li>
                                @endif
{{--
                                
                                <li><a href="portfolio-4-col.html">4 Column Portfolio</a></li>
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

    @include('layouts.script')

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

    @yield('script')

</body>

</html>
