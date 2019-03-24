
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">
    
        <!-- Activity Banner -->
        <div class="row">
            <br>
            <div class="col-md-10 col-md-offset-1">
                <img class="img-responsive" src="{{ !is_null($banner) ? asset('/storage/banners/' . $banner->name) : 'http://placehold.it/1050x450' }}" alt="{{ $info->name }}">
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header" style="text-align:center;">
                    {{ $info->name }}
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Activity Intro -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header"></h2>
            </div>
            <div>
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'introduce' ? 'active' : '' }}">
                        <a href="#introduce" data-toggle="tab">
                            <i class="fa fa-info-circle"></i>
                            活動介紹
                        </a>
                    </li>
                    <li class="{{ $tab == 'register' ? 'active' : '' }}">
                        <a href="#register" data-toggle="tab">
                            <i class="fa fa-rocket"></i>
                            報名
                        </a>
                    </li>
                    <li class="{{ $tab == 'log' ? 'active' : '' }}">
                        <a href="#log" data-toggle="tab">
                            <i class="fa fa-sticky-note"></i> 
                            日誌
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'introduce' ? 'active in' : '' }}" id="introduce">
                        <p>
                            <h3>
                                活動時間：
                                @if ($carbon->parse($info->start_time)->toDateString() != $carbon->parse($info->end_time)->toDateString())
                                    {{ $carbon->parse($info->start_time)->toDateString() }}
                                     ~ 
                                    {{ $carbon->parse($info->end_time)->toDateString() }}
                                @else
                                    {{ $carbon->parse($info->start_time)->toDateString() }}
                                @endif
                            </h3>
                            {!! $info->intro !!}
                            <h3>活動地點：{{ $info->venue }}</h3>
                            <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $info->venue }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                            @if (!empty($info->venue_intro))
                                <h3>{{ $info->venue_intro }}</h3>
                            @endif
                        </p>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'register' ? 'active in' : '' }}" id="register">
                        @can('apply', $info)
                            <a href="{{ route('sign-up::apply::new', ['activity' => $info->id]) }}" class="btn btn-primary">
                                <i class="glyphicon glyphicon-pencil"></i>
                                報名
                            </a>
                        @else
                            @if (!is_null(Auth::user()) && Auth::user()->role_id == 1)
                                <a href="{{ route('sign-up::apply::new', ['activity' => $info->id]) }}" class="btn btn-primary" disabled>
                                    您已報名本活動，請至「參加的活動」查詢報名紀錄
                                </a>
                            @endif
                        @endcan
                    </div>
                    <div class="tab-pane fade {{ $tab == 'log' ? 'active in' : '' }}" id="log">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>標題</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $log->title }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $logs
                                    ->appends($logs_page)
                                    ->appends('tab', 'log')
                                    ->links()
                            !!}
                        </div>
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