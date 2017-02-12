
@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">帳戶資訊</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/account/info/save')}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">電子郵件</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{isset($info->email) ? $info->email : old('email')}}">

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

                        <hr>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名稱</label>

                            <div class="col-md-6">
                                <input id="name" class="form-control" name="name" value="{{isset($profile->name) ? $profile->name : old('name')}}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        @if($info->role_id == '1')
                            <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                <label for="mobile_phone" class="col-md-4 control-label">手機號碼</label>
                                <div class="col-md-6">
                                    <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{isset($profile->mobile_phone) ? $profile->mobile_phone : old('mobile_phone')}}">
                                
                                    @if ($errors->has('mobile_phone'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('mobile_phone')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @elseif($info->role_id == 2)
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">地址</label>
                                <div class="col-md-6">
                                    <input id="address" class="form-control" name="address" value="{{isset($profile->address) ? $profile->address : old('address')}}">
                                
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('address')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">電話</label>
                                <div class="col-md-6">
                                    <input id="phone" class="form-control" name="phone" value="{{isset($profile->phone) ? $profile->phone : old('phone')}}">
                                
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('phone')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                                <label for="fax" class="col-md-4 control-label">傳真</label>
                                <div class="col-md-6">
                                    <input id="fax" class="form-control" name="fax" value="{{isset($profile->fax) ? $profile->fax : old('fax')}}">
                                
                                    @if ($errors->has('fax'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('fax')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                <label for="mobile_phone" class="col-md-4 control-label">手機號碼</label>
                                <div class="col-md-6">
                                    <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{isset($profile->mobile_phone) ? $profile->mobile_phone : old('mobile_phone')}}">
                                
                                    @if ($errors->has('mobile_phone'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('mobile_phone')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> 存檔
                                </button>
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

@section('script')
       
    <!-- Contact Form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

@endsection