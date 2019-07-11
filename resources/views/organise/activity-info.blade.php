
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">活動管理</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <!-- Activity Banner -->
            <div class="col-md-9">
                <!-- First Blog Post -->
                <a href="{{ route('organise::activity::modify', [$activity]) }}">
                    <img class="img-responsive img-hover" style="width:900px; height:300px" src="{{ !is_null($activity_banner) ? asset('/storage/banners/' . $activity_banner->name) : 'http://placehold.it/900x300' }}" alt="{{ $activity->name }}">
                </a>
            </div>

            <!-- Activity Info -->
            <div class="col-md-3">
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
                    @if ($activity->status == 0 || $activity->status == -1)
                        <p>
                            <a class="btn btn-block btn-primary" href="{{ route('organise::activity::modify', [$activity]) }}" role="button">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                編輯
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Activity Manage Feature -->
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('organise::activity::register-certificate::scan', [$activity]) }}" role="button">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                            掃描報到憑證
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('organise::activity::applicant::list', [$activity]) }}" role="button">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                            報名清單
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('organise::activity::log::list', [$activity]) }}" role="button">
                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            活動日誌
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="{{ route('organise::activity::message::list', [$activity]) }}" role="button">
                            <i class="fa fa-commenting-o" aria-hidden="true"></i>
                            訊息推送
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
                @include('partials.copyright-notice')
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection
