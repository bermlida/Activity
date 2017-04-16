
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">
    
        <!-- Image Header -->
        <div class="row">
            <br>
            <div class="col-md-10 col-md-offset-1">
                <img class="img-responsive" src="{{ !is_null($banner) ? asset('/storage/banners/' . $banner->name) : 'http://placehold.it/1050x450' }}" alt="{{ $info->name }}">
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="text-align:center;">
                    {{ $info->name }}
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <div class="row">
            <div class="col-md-6">
                <h3>活動時間：
                @if ($carbon->parse($info->start_time)->toDateString() != $carbon->parse($info->end_time)->toDateString())
                    {{ $carbon->parse($info->start_time)->toDateString() }}
                     ~ 
                    {{ $carbon->parse($info->end_time)->toDateString() }}
                @else
                    {{ $carbon->parse($info->start_time)->toDateString() }}
                @endif
                </h3>
                <h3>活動地點：{{ $info->venue }}</h3>
                    @can('apply', $info)
                        <a href="{{ route('sign-up::apply::new', ['activity' => $info->id]) }}" class="btn btn-primary">
                            <i class="glyphicon glyphicon-pencil"></i>
                            報名
                        </a>
                    @else
                        @if (Auth::user()->role_id == 1)
                            <a href="{{ route('sign-up::apply::new', ['activity' => $info->id]) }}" class="btn btn-primary" disabled>
                                您已報名本活動，請至「參加的活動」查詢報名紀錄
                            </a>
                        @endif
                    @endcan
            </div>
            <div class="col-md-6">
                @if (!empty($info->venue_intro))
                    <h4>{{ $info->venue_intro }}</h4>
                    <h4>({{ $info->venue }})</h4>
                @endif
                <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $info->venue }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <!-- /.row -->

        <!-- Our Customers -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-header">活動介紹</h2>
            </div>
            <div class="col-md-12">
                {!! $info->intro !!}
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