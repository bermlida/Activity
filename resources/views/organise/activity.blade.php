
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

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">
                    {{ $page_method == 'PUT' ? '編輯活動' : '新增活動' }}
                </h1>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Activity Form -->
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ !isset($activity->id) ? route('organise::activity::store') : route('organise::activity::update', ['activity' => $activity->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field($page_method) }}
                <input type="hidden" name="status" value="{{ old('status') }}">

                <div class="form-group">
                    <label class="col-sm-2 control-label">主辦單位</label>

                    <div class="col-sm-8">
                        <p class="form-control-static">
                            {{ $organizer->name }}
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">活動名稱</label>

                    <div class="col-sm-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($activity->name) ? $activity->name : old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="start_time" class="col-sm-2 control-label">開始時間：</label>

                    <div class="col-sm-8">
                        <input id="start_time" type="text" class="datetime-picker" name="start_time" value="{{ isset($activity->start_time) ? $activity->start_time : old('start_time') }}">
                        @if ($errors->has('start_time'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('start_time') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="end_time" class="col-sm-2 control-label">結束時間：</label>

                    <div class="col-sm-8">
                        <input id="end_time" type="text" class="datetime-picker" name="end_time" value="{{ isset($activity->end_time) ? $activity->end_time : old('end_time') }}">
                        @if ($errors->has('end_time'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('end_time') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="venue" class="col-sm-2 control-label">地點：</label>

                    <div class="col-sm-8">
                        <input id="venue" type="text" class="form-control" name="venue" value="{{ isset($activity->venue) ? $activity->venue : old('venue') }}">
                        @if ($errors->has('venue'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('venue') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="venue_intro" class="col-sm-3 col-md-2 control-label">地點補充說明：</label>

                    <div class="col-sm-9 col-md-10">
                        <textarea id="venue_intro" class="form-control" name="venue_intro">{{ isset($activity->venue_intro) ? $activity->venue_intro : old('venue_intro') }}</textarea>
                        @if ($errors->has('venue_intro'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('venue_intro') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="summary" class="col-sm-2 control-label">活動概要：</label>

                    <div class="col-sm-8">
                        <textarea id="summary" class="form-control" name="summary">{{ isset($activity->summary) ? $activity->summary : old('summary') }}</textarea>
                        @if ($errors->has('summary'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('summary') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="apply_start_time" class="col-sm-3 col-md-2 control-label">報名開始時間：</label>

                    <div class="col-sm-9 col-md-10">
                        <input id="apply_start_time" type="text" class="datetime-picker" name="apply_start_time" value="{{ isset($activity->apply_start_time) ? $activity->apply_start_time : old('apply_start_time') }}">
                        @if ($errors->has('apply_start_time'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('apply_start_time') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="apply_end_time" class="col-sm-3 col-md-2 control-label">報名結束時間：</label>

                    <div class="col-sm-9 col-md-10">
                        <input id="apply_end_time" type="text" class="datetime-picker" name="apply_end_time" value="{{ isset($activity->apply_end_time) ? $activity->apply_end_time : old('apply_end_time') }}">
                        @if ($errors->has('apply_end_time'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('apply_end_time') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    @php
                        $is_free = isset($activity->is_free) ? $activity->is_free : old('is_free');
                    @endphp
                    <label class="col-sm-3 col-md-2 control-label">是否為免費活動：</label>

                    <label class="radio-inline">
                        <input type="radio" name="is_free" value="1" {{$is_free == 1 ? 'checked' : '' }}>是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_free" value="0" {{$is_free === 0 ? 'checked' : '' }}>否
                    </label>
                    @if ($errors->has('is_free'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('is_free') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="apply_fee" class="col-sm-2 control-label">報名費用：</label>

                    <div class="col-sm-8">
                        <input id="apply_fee" type="number" class="form-control" name="apply_fee" value="{{ isset($activity->apply_fee) ? ($activity->apply_fee > 0 ? $activity->apply_fee : '') : old('apply_fee') }}">
                        <span class="help-block">(非免費活動必填)</span>
                        @if ($errors->has('apply_fee'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('apply_fee') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    @php
                        $can_sponsored = isset($activity->can_sponsored) ? $activity->can_sponsored : old('can_sponsored');
                    @endphp
                    <label class="col-sm-3 col-md-2 control-label">是否可付費贊助活動：</label>

                    <label class="radio-inline">
                        <input type="radio" name="can_sponsored" value="1" {{ $can_sponsored == 1 ? 'checked' : '' }}>是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="can_sponsored" value="0" {{$can_sponsored === 0 ? 'checked' : '' }}>否
                    </label>
                    @if ($errors->has('can_sponsored'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('can_sponsored') }}
                        </span>
                    @endif
                </div>
                    
                <div class="form-group">
                    <label for="intro" class="col-md-2 control-label">活動介紹：</label>

                    <div class="col-md-10">
                        <textarea id="intro" class="form-control" name="intro">{{ isset($activity->intro) ? $activity->intro : old('intro') }}</textarea>
                        @if ($errors->has('intro'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('intro') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    @if (isset($activity_banner) && !is_null($activity_banner))
                        <label for="photo" class="col-sm-2 control-label">
                            更換宣傳圖片：
                        </label>
                    @else
                        <label for="photo" class="col-sm-2 control-label">
                            宣傳圖片：
                        </label>
                    @endif

                    <div class="col-sm-8">
                        <input type="file" id="photo" class="form-control" name="photo">
                        @if ($errors->has('photo'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('photo') }}
                            </span>
                        @endif
                    </div>
                </div>

                @if (isset($activity_banner) && !is_null($activity_banner))
                    <div class="form-group">
                        <label class="col-sm-3 control-label">宣傳圖片預覽：</label>
                        
                        <div class="col-sm-9">
                            <img class="img-responsive" src="{{ asset('storage/banners/' . $activity_banner->name) }}" alt="{{ $activity->name }}">
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-1">
                        <button type="button" class="btn btn-primary" name="draft">
                            儲存為草稿
                        </button>
                    </div>
                    <div class="col-sm-5 col-xs-5">
                        <button type="button" class="btn btn-success" name="publish">
                            儲存後發布
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

            $("input.datetime-picker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                locale: 'zh-tw'
            });

            // $("input.datetime-picker").datetimepicker({
            //     todayBtn: true,
            //     minuteStep: 5,
            //     language: 'zh-TW'
            // });
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