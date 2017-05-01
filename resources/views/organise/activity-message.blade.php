
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('style')

    <!-- Summernote CSS -->
    <link href="{{ asset('bower_components/summernote/dist/summernote.css') }}" rel="stylesheet">

    <!-- Bootstrap Datetime Picker CSS -->
    <link href="{{ asset('bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker-standalone.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- For success/fail messages -->
        @if (!is_null(session('message_type')) && !is_null(session('message_body')))
            <div class="alert alert-{{ session('message_type') }}" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                {{ session('message_body') }}
            </div>
        @endif

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ $page_title }}
                </h1>
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

        <div class="row">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Activity Form -->
        <div class="row">
            <div class="col-md-8">
                <form class="form-horizontal" role="form" method="POST" action="{{ $form_action }}">
                    {{ csrf_field() }}
                    {{ method_field($form_method) }}
                    <input type="hidden" name="status" value="{{ old('status') }}">

                    <div class="form-group">
                        <label for="subject" class="col-md-2 col-xs-4">主旨：</label>

                        <div class="col-md-10 col-xs-8">
                        <input id="subject" type="text" class="form-control" name="subject" value="{{ $message->subject or old('subject') }}">
                        @if ($errors->has('subject'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('subject') }}
                            </span>
                        @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="content" class="col-md-2 col-xs-4">內容：</label>

                        <div class="col-md-10 col-xs-8">
                            <textarea id="content" class="form-control" name="content">{{ $message->content or old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('content') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        @if (isset($message->sending_method))
                            @php
                                $checked = [
                                    0 => in_array('email', $message->sending_method) ? 'checked' : '',
                                    1 => in_array('sms', $message->sending_method) ? 'checked' : ''
                                ];
                            @endphp
                        @endif
                        <label class="radio-inline">發送方式：</label>

                        <label class="radio-inline">
                            <input type="checkbox" name="sending_method[0]" value="email" {{ $checked[0] or '' }}>E-mail
                        </label>
                        <label class="radio-inline">
                            <input type="checkbox" name="sending_method[1]" value="sms" {{ $checked[1] or '' }}>簡訊
                        </label>
                        @if ($errors->has('sending_method'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('sending_method') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        @if (isset($message->sending_target) && is_array($message->sending_target))
                            @php
                                $checked = [
                                    0 => in_array(1, $message->sending_target) ? 'checked' : '',
                                    1 => in_array(0, $message->sending_target) ? 'checked' : '',
                                    2 => in_array(-1, $message->sending_target) ? 'checked' : ''
                                ];
                            @endphp
                        @endif
                        <label class="radio-inline">發送對象：</label>

                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[0]" value="1" {{ $checked[0] or '' }}>已完成報名
                        </label>
                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[1]" value="0" {{ $checked[1] or '' }}>未完成報名
                        </label>
                        <label class="radio-inline">
                            <input type="checkbox" name="sending_target[2]" value="-1"{{ $checked[2] or '' }}>已取消報名
                        </label>
{{--
                        <label class="radio-inline">
                            <input type="checkbox" name="">特定對象
                        </label>
--}}
                        @if ($errors->has('sending_target'))
                            <span class="help-block" style="color:red">
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
                        @if (isset($message->sending_time))
                            @php
                                $checked = [
                                    'no' => is_null($message->sending_time) ? 'checked' : '',
                                    'yes' => !is_null($message->sending_time) ? 'checked' : ''
                                ];
                            @endphp
                        @elseif (!is_null(old('join_schedule')))
                            @php
                                $checked = [
                                    'no' => old('join_schedule') == 'no' ? 'checked' : '',
                                    'yes' => old('join_schedule') == 'yes' ? 'checked' : ''
                                ];
                            @endphp
                        @endif
                        <label class="radio-inline">發送排程：</label>
                        
                        <label class="radio-inline">
                            <input type="radio" name="join_schedule" value="no" {{ $checked['no'] or '' }}>立刻發送
                        </label>
                        
                        <label class="radio-inline">
                            <input type="radio" name="join_schedule" value="yes" {{ $checked['yes'] or '' }}>特定時間
                            <input id="sending_time" type="text" class="datetime-picker" name="sending_time" value="{{ $message->sending_time or old('sending_time') }}">
                        </label>
                        
                        @if ($errors->has('join_schedule'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('join_schedule') }}
                            </span>
                        @endif

                        @if ($errors->has('sending_time'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('sending_time') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-2 col-xs-5 col-xs-offset-2">
                            
                        </div>
                        <div class="col-md-5 col-xs-5">
                            <button type="button" class="btn btn-primary" name="draft">
                                儲存為草稿
                            </button>
                            <button type="button" class="btn btn-success" name="publish">
                                儲存
                            </button>
                            <button type="button" class="btn btn-success" name="publish">
                                儲存並排成
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

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
    <!-- /.container -->

@endsection

@section('script')

    <!-- Contact Form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    {{-- <script src="js/jqBootstrapValidation.js"></script> --}}

    <!-- Summernote JavaScript -->
    <script src="{{ asset('bower_components/summernote/dist/summernote.min.js') }}"></script>

    <!-- Moment JavaScript -->
    <script src="{{ asset('bower_components/moment/min/moment-with-locales.min.js') }}"></script>

    <!-- Bootstrap Datetime Picker JavaScript -->
    <script src="{{ asset('bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#content").summernote({
                height: 500,
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