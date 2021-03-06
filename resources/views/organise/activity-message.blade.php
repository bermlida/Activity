
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('style')

    <!-- Summernote CSS -->
    <link href="{{ asset('components/summernote/dist/summernote.css') }}" rel="stylesheet">

    <!-- Bootstrap Datetime Picker CSS -->
    <link href="{{ asset('components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker-standalone.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">{{ $page_title }}</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Activity Info -->
        <div class="row">
            <div class="col-xs-12">
                <p>活動名稱：{{ $activity->name }}</p>
                <p>
                    活動時間：
                    {{ $activity->start_time->format('Y-m-d H:i') }}
                     ~ 
                    {{ $activity->end_time->format('Y-m-d H:i') }}
                </p>
                <p>活動地點：{{ $activity->venue }}</p>
            </div>
        </div>
        <!-- /.row -->

        <!-- Horizontal Divider -->
        <div class="row">
            <div class="col-xs-12">
                <hr>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Activity Message Form -->
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ $form_action }}">
                {{ csrf_field() }}
                {{ method_field($form_method) }}
                <input type="hidden" name="status" value="{{ old('status') }}">

                <div class="form-group">
                    <label for="subject" class="col-sm-2 control-label">主旨</label>

                    <div class="col-sm-8">
                        <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject', ($message->subject ?? '')) }}">

                        @if ($errors->has('subject'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('subject') }}
                            </span>
                        @endif
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">內容</label>

                    <div class="col-sm-8">
                        <textarea id="content" class="form-control" name="content">{{ old('content', ($message->content ?? '')) }}</textarea>

                        @if ($errors->has('content'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('content') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">發送方式</label>

                    <label class="radio-inline">
                        <input type="checkbox" name="sending_method[0]" value="email" {{ in_array('email', old('sending_method', ($message->sending_method ?? []))) ? 'checked' : ''}}>E-mail
                    </label>
                    <label class="radio-inline">
                        <input type="checkbox" name="sending_method[1]" value="sms" {{ in_array('sms', old('sending_method', ($message->sending_method ?? []))) ? 'checked' : ''}}>簡訊
                    </label>

                    @if ($errors->has('sending_method'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('sending_method') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">發送對象</label>

                    <label class="radio-inline">
                        <input type="checkbox" name="sending_target[0]" value="1" {{ in_array(1, old('sending_target', ($message->sending_target ?? []))) ? 'checked' : ''}}>已完成報名
                    </label>
                    <label class="radio-inline">
                        <input type="checkbox" name="sending_target[1]" value="0" {{ in_array(0, old('sending_target', ($message->sending_target ?? []))) ? 'checked' : ''}}>未完成報名
                    </label>
                    <label class="radio-inline">
                        <input type="checkbox" name="sending_target[2]" value="-1"{{ in_array(-1, old('sending_target', ($message->sending_target ?? []))) ? 'checked' : ''}}>已取消報名
                    </label>
{{--
                        <label class="radio-inline">
                            <input type="checkbox" name="">特定對象
                        </label>
--}}
                    @if ($errors->has('sending_target'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('sending_target') }}
                        </span>
                    @endif
                </div>
{{--
                    <div class="form-group">
                        <label class="radio-inline"><b>發送給特定對象：</b></label>

                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[3][]" value="5">A
                        </label>
                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[3][]" value="67">B
                        </label>
                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[3][]" value="100">C
                        </label>
                        @if ($errors->has('sending_target.3'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('sending_target.3') }}
                            </span>
                        @endif
                    </div>
--}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">發送排程</label>
                    
                    <label class="radio-inline">
                        <input type="radio" name="join_schedule" value="no" {{ old('join_schedule', ((isset($message->sending_time) && !is_null($message->sending_time)) ? 'yes' : 'no')) == 'no' ? 'checked' : '' }}>立刻發送
                    </label>                    
                    <label class="radio-inline">
                        <input type="radio" name="join_schedule" value="yes" {{ old('join_schedule', ((isset($message->sending_time) && !is_null($message->sending_time)) ? 'yes' : 'no')) == 'yes' ? 'checked' : '' }}>特定時間
                        <input id="sending_time" type="text" class="datetime-picker" name="sending_time" value="{{ old('sending_time', ($message->sending_time ?? '')) }}">
                    </label>

                    @if ($errors->has('join_schedule'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('join_schedule') }}
                        </span>
                    @endif
                    @if ($errors->has('sending_time'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('sending_time') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-1">
                        <button type="button" class="btn btn-primary" name="draft">
                            儲存為草稿
                        </button>
                    </div>
                    <div class="col-sm-5 col-xs-5">
                        <button type="button" class="btn btn-success" name="publish">
                            儲存
                        </button>
                    </div>
                </div>
            </form>
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

@section('script')

    <!-- Contact Form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    {{-- <script src="js/jqBootstrapValidation.js"></script> --}}

    <!-- Summernote JavaScript -->
    <script src="{{ asset('components/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('components/summernote/dist/lang/summernote-zh-TW.min.js') }}"></script>

    <!-- Moment JavaScript -->
    <script src="{{ asset('components/moment/min/moment-with-locales.min.js') }}"></script>

    <!-- Bootstrap Datetime Picker JavaScript -->
    <script src="{{ asset('components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#content").summernote({
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

            $("input.datetime-picker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                locale: 'zh-tw'
            });

        });

        $("input[name=join_schedule]").click(function () {
            join = $(this).val();

            if (join == "yes") {
                $("input[name=sending_time]").prop("disabled", false);
            } else {
                $("input[name=sending_time]").prop("disabled", true);
            }
        });

        $("button[name]").click(function () {
            var action = $(this).attr("name");

            if (action == "draft") {
                $("input[name=status]").val(0);
            } else if (action == "publish") {
                $("input[name=status]").val(1);
            }

            $("form").submit();
        });

    </script>

@endsection