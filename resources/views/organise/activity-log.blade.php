
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('style')

    <!-- Summernote CSS -->
    <link href="{{ asset('components/summernote/dist/summernote.css') }}" rel="stylesheet">

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
        
        <!-- Activity Log Form -->
        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ $form_action }}">
                {{ csrf_field() }}
                {{ method_field($form_method) }}
                <input type="hidden" name="status" value="{{ old('status') }}">

                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">內容類型</label>

                    <label class="radio-inline">
                        <input type="radio" name="content_type" value="blog" {{ old('content_type', (isset($log) ? $log->content_type : '')) == 'blog' ? 'checked' : '' }}>文字
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="content_type" value="plog" {{ old('content_type', (isset($log) ? $log->content_type : '')) == 'plog' ? 'checked' : '' }}>圖片
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="content_type" value="vlog" {{ old('content_type', (isset($log) ? $log->content_type : '')) == 'vlog' ? 'checked' : '' }}>影片
                    </label>
                    @if ($errors->has('content_type'))
                        <span class="help-block col-xs-offset-2" style="color:red">
                            {{ $errors->first('content_type') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">標題</label>

                    <div class="col-sm-8">
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title', (isset($log) ? $log->title : '')) }}">
                        @if ($errors->has('title'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="content" class="col-sm-2 control-label">內容</label>

                    <div class="col-sm-8">
                        <textarea id="blog_content" class="form-control" name="blog_content" {{ old('content_type', (isset($log) ? $log->content_type : '')) != 'blog' ? 'style="display:none;"' : '' }}>{{ old('blog_content', (isset($log) && $log->content_type == 'blog' ? $log->content : '')) }}</textarea>
                        <input type="file" id="plog_content" class="form-control" name="plog_content" {{ old('content_type', (isset($log) ? $log->content_type : '')) != 'plog' ? 'style="display:none;"' : '' }}>
                        <input type="file" id="vlog_content" class="form-control" name="vlog_content" {{ old('content_type', (isset($log) ? $log->content_type : '')) != 'vlog' ? 'style="display:none;"' : '' }}>

                        @if ($errors->has('blog_content') || $errors->has('plog_content') || $errors->has('vlog_content'))
                            <span class="help-block" style="color:red">
                                @if ($errors->has('blog_content'))
                                    {{ $errors->first('blog_content') }}
                                @elseif ($errors->has('plog_content'))
                                    {{ $errors->first('plog_content') }}
                                @elseif ($errors->has('vlog_content'))
                                    {{ $errors->first('vlog_content') }}
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                @if (isset($log) && $log->content_type == 'plog')
                    <div class="form-group" id="plog_preview">
                        <label class="col-sm-3 control-label">圖片預覽</label>
                        
                        <div class="col-sm-9">
                            <img class="img-responsive" src="{{ asset('storage/' . $log->activity->id . '/plogs/' . $attachment->name) }}" alt="{{ $attachment->name }}">
                        </div>
                    </div>
                @endif

                @if (isset($log) && $log->content_type == 'vlog')
                    <div class="form-group" id="vlog_preview">
                        <label class="col-sm-3 control-label">影片預覽</label>
                        
                        <div class="col-sm-9">
                            <video width="320" height="240" controls autoplay>
                                <source src="{{ asset('storage/' . $log->activity->id . '/vlogs/' . $attachment->name) }}" type="video/mp4">
                                您的瀏覽器並不支援預覽影片
                            </video>
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
    <script src="{{ asset('components/summernote/dist/summernote.min.js') }}"></script>

    <!-- Moment JavaScript -->
    <script src="{{ asset('components/moment/min/moment-with-locales.min.js') }}"></script>

    <!-- Bootstrap Datetime Picker JavaScript -->
    <script src="{{ asset('components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#blog_content").summernote({
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

        $("input[name=content_type]").change(function () {
            var content_type = $(this).val();

            $("[name$='_content']").hide();
            $("[name=" + content_type + "_content]").show();

            if ($("div[id$='_preview']").length) {
                $("div[id$='_preview']").hide();

                if ($("#" + content_type + "_preview").length) {
                    $("#" + content_type + "_preview").show();
                }
            }
        });

        $("#plog_content").change(function () {
            $("#plog_preview]").remove();
        });

        $("#vlog_content").change(function () {
            $("#vlog_preview]").remove();
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