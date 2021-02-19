
@extends('layouts.main')

@section('style')

    <!-- Summernote CSS -->
    <link href="{{ asset('components/summernote/dist/summernote.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">基本資料</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('account::info::save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-2 control-label">名稱</label>

                    <div class="col-sm-8">
                        <input id="name" class="form-control" name="name" value="{{ old('name', ($profile->name ?? '')) }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @if ($account->role_id == '1')

                    <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                        <label for="mobile_phone" class="col-sm-2 control-label">手機號碼</label>

                        <div class="col-sm-8">
                            <select class="form-control" name="mobile_country_calling_code">
                                @foreach ($country_calling_codes as $code_key => $code_name)
                                    <option value="{{ $code_key }}" {{ old('mobile_country_calling_code', ($profile->mobile_country_calling_code ?? '')) == $code_key ? 'selected' : '' }}>{{ $code_name }}</option>
                                @endforeach
                            </select>
                            <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{ old('mobile_phone', ($profile->mobile_phone ?? '')) }} ">
                                
                            @if ($errors->has('mobile_phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                @elseif ($account->role_id == 2)

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address" class="col-sm-2 control-label">地址</label>

                        <div class="col-sm-8">
                            <input id="address" class="form-control" name="address" value="{{ old('address', ($profile->address ?? '')) }}">
                                
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 control-label">電話</label>

                        <div class="col-sm-8">
                            <input id="phone" class="form-control" name="phone" value="{{ old('phone', ($profile->phone ?? '')) }}">
                                
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                            
                    <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                        <label for="fax" class="col-sm-2 control-label">傳真</label>

                        <div class="col-sm-8">
                            <input id="fax" class="form-control" name="fax" value="{{ old('fax', ($profile->fax ?? '')) }}">
                                
                            @if ($errors->has('fax'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                        <label for="mobile_phone" class="col-sm-2 control-label">手機號碼</label>

                        <div class="col-sm-8">
                            <select class="form-control" name="mobile_country_calling_code">
                                @foreach ($country_calling_codes as $code_key => $code_name)
                                    <option value="{{ $code_key }}" {{ old('mobile_country_calling_code', ($profile->mobile_country_calling_code ?? '')) == $code_key ? 'selected' : '' }}>{{ $code_name }}</option>
                                @endforeach
                            </select>
                            <input id="mobile_phone" class="form-control" name="mobile_phone" value="{{ old('mobile_phone', ($profile->mobile_phone ?? '')) }} ">
                                
                            @if ($errors->has('mobile_phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
                        <label for="intro" class="col-sm-2 control-label">介紹</label>
                            
                        <div class="col-sm-8">
                            <textarea id="intro" class="form-control" name="intro">{{ old('intro', ($profile->intro ?? '')) }}</textarea>
                                
                            @if ($errors->has('intro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('intro') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo" class="col-sm-2 control-label">
                            {{ isset($banner) && !is_null($banner) ? '更換宣傳圖片' : '宣傳圖片'}}
                        </label>

                        <div class="col-sm-8">
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
                            <label class="col-sm-3 control-label">宣傳圖片預覽</label>

                            <div class="col-sm-9">
                                <img class="img-responsive" src="{{ $banner->secure_url }}" alt="{{ $profile->name }}">
                            </div>
                        </div>
                    @endif
                        
                @endif
                        
                <div class="form-group">
                    <div class="col-xs-6 col-md-offset-5 col-xs-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                            存檔
                        </button>
                    </div>
                </div>
                
            </form>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                @include('partials.copyright-notice')
            </div>
        </footer>
    </div>

@endsection

@section('script')
       
    <!-- Contact Form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Summernote JavaScript -->
    <script src="{{ asset('components/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('components/summernote/dist/lang/summernote-zh-TW.min.js') }}"></script>

    <script type="text/javascript">
        
        $(document).ready(function() {

            $("#intro").summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['undo', ['undo']],
                    ['redo', ['redo']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                    ['fontstyle', ['superscript', 'subscript']],
                    ['clear', ['clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['Insert', ['picture', 'link', 'video', 'table', 'hr']],
                    ['fullscreen', ['fullscreen']],
                    ['help', ['help']]
                ],
                height: 500,
                minHeight: 100,
                lang: 'zh-TW',
                focus: true
            });

        });

    </script>

@endsection