
@extends('layouts.main')

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
                     基本資料
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('account::info::save') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">名稱</label>

                        <div class="col-md-6">
                            <input id="name" class="form-control" name="name" value="{{ isset($profile->name) ? $profile->name : old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($account->role_id == '1')
                        <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                            <label for="mobile_phone" class="col-md-4 control-label">手機號碼</label>

                            <div class="col-md-6">
                                <select class="form-control" name="mobile_country_calling_code">
                                    @foreach ($country_calling_codes as $code_key => $code_name)
                                        @if (!is_null(old('mobile_country_calling_code')))
                                            <option value="{{ $code_key }}" {{ old('mobile_country_calling_code') == $code_key ? 'selected' : '' }}>{{ $code_name }}</option>
                                        @elseif (isset($profile->mobile_country_calling_code))
                                            <option value="{{ $code_key }}" {{ $profile->mobile_country_calling_code == $code_key ? 'selected' : '' }}>{{ $code_name }}</option>
                                        @else
                                            <option value="{{ $code_key }}">{{ $code_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{ isset($profile->mobile_phone) ? $profile->mobile_phone : old('mobile_phone')}} ">
                                
                                @if ($errors->has('mobile_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @elseif ($account->role_id == 2)
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">地址</label>

                            <div class="col-md-6">
                                <input id="address" class="form-control" name="address" value="{{ isset($profile->address) ? $profile->address : old('address') }}">
                                
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">電話</label>

                            <div class="col-md-6">
                                <input id="phone" class="form-control" name="phone" value="{{ isset($profile->phone) ? $profile->phone : old('phone') }}">
                                
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                        <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                            <label for="fax" class="col-md-4 control-label">傳真</label>
                            <div class="col-md-6">
                                <input id="fax" class="form-control" name="fax" value="{{ isset($profile->fax) ? $profile->fax : old('fax') }}">
                                
                                @if ($errors->has('fax'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fax') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                            <label for="mobile_phone" class="col-md-4 control-label">手機號碼</label>

                            <div class="col-md-6">
                                <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{ isset($profile->mobile_phone) ? $profile->mobile_phone : old('mobile_phone') }}">
                                
                                @if ($errors->has('mobile_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
                            <label for="intro" class="col-md-4 control-label">介紹</label>
                            
                            <div class="col-md-6">
                                <textarea id="intro" class="form-control" name="intro">{{ isset($profile->intro) ? $profile->intro : old('intro') }}</textarea>
                                
                                @if ($errors->has('intro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('intro') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo" class="col-md-4 control-label">
                                {{ isset($banner) && !is_null($banner) ? '更換宣傳圖片' : '宣傳圖片'}}
                            </label>

                            <div class="col-md-8">
                                <input type="file" id="photo" class="form-control" name="photo">
                                @if ($errors->has('photo'))
                                    <span class="help-block" style="color:red">
                                        {{ $errors->first('photo') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if (isset($banner) && !is_null($banner))
                            <div class="form-group">
                                <label class="col-md-3 control-label">宣傳圖片預覽</label>

                                <div class="col-md-9">
                                    <img class="img-responsive" src="{{ asset('storage/banners/' . $banner->name) }}" alt="{{ $profile->name }}">
                                </div>
                            </div>
                        @endif
                    @endif
                        
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