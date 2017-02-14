
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ $page_method == 'PUT' ? '編輯活動' : '新增活動' }}
                    <small></small>
                </h1>
                <label>主辦單位：{{ $organizer->name }}</label>
            </div>
        </div>
        <!-- /.row -->

        <!-- Contact Form -->
        <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
        <div class="row">
            <div class="col-md-8">
                <h3></h3>
                <form role="form" method="POST" action="{{ url('/organise/activity') }}">
                    {{ csrf_field() }}
                    {{ method_field($page_method) }}
                    <input type="hidden" name="status" value="{{ old('status') }}">

                    @if (isset($activity->id))
                        <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                        @if ($errors->has('activity_id'))
                            <span class="help-block" style="color:red">
                                {{ $errors->first('activity_id') }}
                            </span>
                        @endif
                    @endif

                    <div class="form-group">
                        <div class="controls">
                            <label for="name" class="col-md-2 col-xs-4 control-label">活動名稱：</label>

                            <div class="col-md-10 col-xs-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ isset($activity->name) ? $activity->name : old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="start_time" class="col-md-2 col-xs-4 control-label">開始時間：</label>

                            <div class="col-md-10 col-xs-8">
                            <input id="start_time" type="date" class="form-control" name="start_time" value="{{ isset($activity->start_time) ? $carbon->parse($activity->start_time)->toDateString() : old('start_time') }}">
                             @if ($errors->has('start_time'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('start_time') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="end_time" class="col-md-2 col-xs-4 control-label">結束時間：</label>

                            <div class="col-md-10 col-xs-8">
                            <input id="end_time" type="date" class="form-control" name="end_time" value="{{ isset($activity->end_time) ? $carbon->parse($activity->end_time)->toDateString() : old('end_time') }}">
                             @if ($errors->has('end_time'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('end_time') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="venue" class="col-md-2 col-xs-4 control-label">地點：</label>

                            <div class="col-md-10 col-xs-8">
                            <input id="venue" type="text" class="form-control" name="venue" value="{{ isset($activity->venue) ? $activity->venue : old('venue') }}">
                             @if ($errors->has('venue'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('venue') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="venue_intro" class="col-md-2 col-xs-4 control-label">補充說明：</label>

                            <div class="col-md-10 col-xs-8">
                            <textarea id="venue_intro" class="form-control" name="venue_intro">{{ isset($activity->venue_intro) ? $activity->venue_intro : old('venue_intro') }}</textarea>
                             @if ($errors->has('venue_intro'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('venue_intro') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="summary" class="col-md-2 col-xs-4 control-label">活動概要：</label>

                            <div class="col-md-10 col-xs-8">
                            <textarea id="summary" class="form-control" name="summary">{{ isset($activity->summary) ? $activity->summary : old('summary') }}</textarea>
                             @if ($errors->has('summary'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('summary') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>

                    <div class="form-group">
                        <div class="controls">
                            <label for="intro" class="col-md-2 col-xs-4 control-label">活動介紹：</label>

                            <div class="col-md-10 col-xs-8">
                            <textarea id="intro" class="form-control" name="intro">{{ isset($activity->intro) ? $activity->intro : old('intro') }}</textarea>
                             @if ($errors->has('intro'))
                                <span class="help-block" style="color:red">
                                    {{ $errors->first('intro') }}
                                </span>
                            @endif
                            </div>
                        </div>
                    </div><br><br><br>
{{--
                    <div id="success">123456</div>
--}}
                    <!-- For success/fail messages -->
                    <div class="form-group">
                        <div class="controls"> 
                            <div class="col-md-5 col-md-offset-2 col-xs-5 col-xs-offset-2">
                                <button type="button" class="btn btn-primary" name="draft">
                                    儲存為草稿
                                </button>
                            </div>
                            <div class="col-md-5 col-xs-5">
                                <button type="button" class="btn btn-success" name="publish">
                                    儲存後發佈
                                </button>
                            </div>
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
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <script type="text/javascript">
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