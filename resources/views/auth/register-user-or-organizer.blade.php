@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">請先註冊</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <a class="btn btn-block" href="{{ route('social-auth::register::ask', ['social_provider' => $social_provider, 'role' => 'organizer']) }}">
                            <i class="fa fa-sitemap" aria-hidden="true"></i>
                            註冊為主辦單位
                        </a>
                        <a class="btn btn-block" href="{{ route('social-auth::register::ask', ['social_provider' => $social_provider, 'role' => 'user']) }}">
                            <span class="fa fa-user-circle" aria-hidden="true"></span>
                            註冊為會員
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection
