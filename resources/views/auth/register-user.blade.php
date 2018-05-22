
@extends('layouts.main')

@section('style')

    <!-- Bootstrap Social CSS -->
    <link href="{{ asset('bower_components/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                @if (!is_null(session('message_type')) && !is_null(session('message_body')))
                    <div class="alert alert-{{ session('message_type') }}" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        {{ session('message_body') }}
                    </div>
                @endif
                <h1 class="page-header">
                    註冊為會員
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register::user::store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-4 control-label">名稱</label>

                        <div class="col-sm-6">
                            <input id="name" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

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

                    <div class="form-group{{ $errors->has('mobile_country_calling_code') || $errors->has('mobile_phone') ? ' has-error' : '' }}">
                        <label for="mobile_phone" class="col-sm-4 control-label">手機號碼</label>

                        <div class="col-sm-6">
                            <select class="form-control" name="mobile_country_calling_code">
                                @foreach (config('constant.CountryCallingCodes') as $code => $code_name)
                                    @if ($code == old('mobile_country_calling_code'))
                                        <option value="{{ $code }}" selected>{{ $code_name }}</option>
                                    @else
                                        <option value="{{ $code }}">{{ $code_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{ old('mobile_phone') }} ">
                            
                            @if ($errors->has('mobile_country_calling_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_country_calling_code') }}</strong>
                                </span>
                            @endif 
                            @if ($errors->has('mobile_phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_phone') }}</strong>
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

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-sm-4 control-label">密碼確認</label>

                        <div class="col-sm-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                註冊
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <a class="btn btn-block btn-social btn-facebook" href="{{ route('social-auth::register::ask', ['social_provider' => 'facebook', 'role' => 'user']) }}">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            以 Facebook 登入
                        </a>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-block btn-social btn-google" href="{{ route('social-auth::register::ask', ['social_provider' => 'google', 'role' => 'user']) }}">
                            <i class="fa fa-google" aria-hidden="true"></i>
                            以 Google+ 登入
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

@section('script')
       
    <!-- Contact Form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

@endsection