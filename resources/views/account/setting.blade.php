
@extends('layouts.main')

@section('style')

    

@endsection

@section('content')

    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
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
                    帳戶設定
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('account::setting::save') }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">電子郵件</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ isset($setting->email) ? $setting->email : session('email') }}" disabled>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">密碼變更</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">密碼變更確認</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-6">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                存檔
                            </button>
                        </div>
                    </div>
                </form>
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

    

@endsection