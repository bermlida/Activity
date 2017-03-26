@extends('layouts.main')

@section('style')

    <!-- Bootstrap Social CSS -->
    <link href="{{ asset('bower_components/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">會員 / 主辦單位登入</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <a class="btn btn-block btn-social btn-facebook" href="{{ url('/social-auth/facebook') }}">
                                    <span class="fa fa-facebook"></span>
                                    以 Facebook 登入
                                </a>
                                <a class="btn btn-block btn-social btn-google" href="{{ url('/social-auth/google') }}">
                                    <span class="fa fa-google"></span>
                                    以 Google+ 登入
                                </a>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">電子郵件</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密碼</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">
                                        記住此帳號 ( 公用電腦請勿勾選 )
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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
