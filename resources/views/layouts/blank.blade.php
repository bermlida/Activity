<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>精進之門 - 佛教活動平台</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('components/bootstrap/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="{{ asset('components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

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

    @yield('content')

     <!-- jQuery Javascript -->
    <script src="{{ asset('components/jquery/dist/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('components/jquery/dist/jquery.slim.min.js') }}"></script> --}}

    <!-- Bootstrap JavaScript -->
    <script src="{{ asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @yield('script')

</body>

</html>
