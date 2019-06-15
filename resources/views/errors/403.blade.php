
@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    403
                    <small>Forbidden</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Error 404 Message -->
        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h1><span class="error">403</span></h1>
                    <p>您無法瀏覽這個頁面。您可藉由以下鏈接繼續：</p>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">首頁</a>
                        </li>
                        <li>
                            <a href="{{ route('visit::activities') }}">找活動</a>
                        </li>
                        <li>
                            <a href="{{ route('visit::organizers') }}">找主辦單位</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection
