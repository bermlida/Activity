
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    活動管理
                    <small></small>
                </h1>
{{-- 
                <ol class="breadcrumb">
                    <li><a href="index.html">我所舉辦的活動</a></li>
                    <li class="active">活動管理</li>
                </ol>
 --}}
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-9">
                <!-- First Blog Post -->
                <a href="{{ route('organise::activity::modify', [$activity]) }}">
                    <img class="img-responsive img-hover" style="width:900px; height:300px" src="{{ !is_null($activity_banner) ? asset('/storage/banners/' . $activity_banner->name) : 'http://placehold.it/900x300' }}" alt="{{ $activity->name }}">
                </a>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">
                <!-- Side Widget Well -->
                <div class="well">
                    <h4>{{ $activity->name }}</h4>
                    <p>
                        @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                            {{ $activity->start_time->format('Y-m-d H:i') }}
                             ~ 
                            {{ $activity->end_time->format('Y-m-d H:i') }}
                        @else
                            {{ $activity->start_time->toDateString() }}
                            {{ $activity->start_time->format('H:i') }}
                             ~ 
                            {{ $activity->end_time->format('H:i') }}
                        @endif
                    </p>
                    <p>{{ $activity->venue }}</p>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>報名</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" role="button" href="{{ route('organise::activity::register-certificate::scan', [$activity]) }}">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            掃描報到憑證
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" role="button" href="{{ route('organise::activity::applicants::list', [$activity]) }}">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            報名清單
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>互動</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            直播
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('organise::activity::message::list', [$activity]) }}" role="button">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            訊息推送
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>收退款</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            收款狀態
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            退款清單
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>紀錄</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            日誌管理
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            影音管理
                        </a>
                    </div>
                </div>
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
