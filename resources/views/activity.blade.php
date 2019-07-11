
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('style')

    <!-- jQuery Colorbox CSS -->
    <link href="{{ asset('components/jquery-colorbox/example1/colorbox.css') }}" rel="stylesheet">

@endsection

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
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            活動介紹
                        </a>
                    </li>
                    <li class="{{ $tab == 'time-and-venue' ? 'active' : '' }}">
                        <a href="#time-and-venue" data-toggle="tab">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            時間及地點
                        </a>
                    </li>
                    <li class="{{ $tab == 'register' ? 'active' : '' }}">
                        <a href="#register" data-toggle="tab">
                            <i class="fa fa-rocket" aria-hidden="true"></i>
                            報名
                        </a>
                    </li>
                    <li class="{{ $tab == 'log' ? 'active' : '' }}">
                        <a href="#log" data-toggle="tab">
                            <i class="fa fa-sticky-note" aria-hidden="true"></i> 
                            日誌
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'introduce' ? 'active in' : '' }}" id="introduce">
                        <p>
                            {!! $info->intro !!}
                        </p>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'time-and-venue' ? 'active in' : '' }}" id="time-and-venue">
                        <p>
                            <h4>
                                活動時間：
                                @if ($info->start_time->toDateString() != $info->end_time->toDateString())
                                    {{ $info->start_time->toDateString() }}
                                     ~ 
                                    {{ $info->end_time->toDateString() }}
                                @else
                                    {{ $info->start_time->toDateString() }}
                                @endif
                            </h4>
                            <h4>活動地點：{{ $info->venue }}</h4>
                            <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $info->venue }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                            @if (!empty($info->venue_intro))
                                <h4 style="text-align: center;">{{ $info->venue_intro }}</h4>
                            @endif
                        </p>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'register' ? 'active in' : '' }}" id="register">
                        <br>
                        @if ($carbon->now()->between($info->apply_start_time, $info->apply_end_time))
                            @can('apply', $info)
                                <a href="{{ route('sign-up::apply::new', ['activity' => $info->id]) }}" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                    報名
                                </a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-primary" disabled>
                                    @if (!is_null(Auth::user()))
                                        @if (Auth::user()->role_id == 1)                                    
                                            您已報名本活動，請至「參加的活動」查詢報名紀錄
                                        @else                                    
                                            主辦單位不得報名活動                                    
                                        @endif
                                    @else                                 
                                        請先登入才能報名活動                                
                                    @endif
                                </a>
                            @endcan
                        @else
                            <a href="javascript:void(0);" class="btn btn-primary" disabled>
                                @if ($carbon->now()->lessThan($info->apply_start_time))
                                    活動尚未開放報名
                                @elseif ($carbon->now()->greaterThan($info->apply_end_time))
                                    活動已截止報名
                                @else
                                    活動無法報名
                                @endif
                            </a>
                        @endif
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
                                        <td>
                                            <a class="activity-log" href="{{ route('visit::activity::log', ['activity' => $info->id, 'log' => $log->id]) }}">
                                                {{ $log->title }}
                                            </a>
                                        </td>
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
                @include('partials.copyright-notice')
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection

@section('script')

    <!-- jQuery Colorbox Javascript -->
    <script src="{{ asset('components/jquery-colorbox/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('components/jquery-colorbox/i18n/jquery.colorbox-zh-TW.js') }}"></script>

    <script type="text/javascript">

        $('a.activity-log').colorbox({
            width: "100%",
            height: "100%"
        });

    </script>

@endsection