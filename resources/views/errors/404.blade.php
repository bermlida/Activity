
@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    404
                    <small>Page Not Found</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Error 404 Message -->
        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <h1><span class="error">404</span></h1>
                    <p>找不到您要查找的頁面。您可藉由以下鏈接繼續：</p>
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
                @include('partials.copyright-notice')
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection
