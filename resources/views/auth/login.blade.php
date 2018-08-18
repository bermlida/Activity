@extends('layouts.main')

@section('style')

    <!-- Bootstrap Social CSS -->
    <link href="{{ asset('components/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="container">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-xs-12">
            @include('partials.alert-message')
                
            <h1 class="page-header">登入</h1>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-sm-4 control-label">電子郵件</label>

                    <div class="col-sm-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-sm-4 control-label">密碼</label>

                    <div class="col-sm-6">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember">
                                記住此帳號 ( 公用電腦請勿勾選 )
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-4 col-xs-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> 登入
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            密碼忘記了嗎 ?
                        </a>
                    </div>
                </div>

                
            </form>
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-sm-6 col-sm-offset-4">
            <a class="btn btn-block btn-social btn-facebook" href="{{ route('social-auth::login::ask', ['social_provider' => 'facebook']) }}" role="button">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                以 Facebook 登入
            </a>
            <a class="btn btn-block btn-social btn-google" href="{{ route('social-auth::login::ask', ['social_provider' => 'google']) }}" role="button">
                <i class="fa fa-google" aria-hidden="true"></i>
                以 Google+ 登入
            </a>
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
