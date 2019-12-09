
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Organizer Banner -->
        <div class="row">
            <br>
            <div class="col-md-10 col-md-offset-2">
                <img class="img-responsive" src="{{ !is_null($banner) ? asset('storage/banners/' . $banner->name) : 'https://placehold.it/750x450' }}" alt="{{ $info->name }}">
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

        <!-- Organizer Intro -->
        <div class="row">
            <div class="col-xs-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'activities' ? 'active' : '' }}">
                        <a href="#activities" data-toggle="tab">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            當前活動
                        </a>
                    </li>
                    <li class="{{ $tab == 'histories' ? 'active' : '' }}">
                        <a href="#histories" data-toggle="tab">
                            <i class="fa fa-history" aria-hidden="true"></i>
                            歷史活動
                        </a>
                    </li>
                    <li class="">
                        <a href="#map" data-toggle="tab">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            聯絡及交通方式
                        </a>
                    </li>
                    <li class="">
                        <a href="#about" data-toggle="tab">
                            <i class="fa fa-tree" aria-hidden="true"></i>
                            關於
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'activities' ? 'active in' : '' }}" id="activities">
                        <br>
                        @forelse ($activities as $activity)
                            <div class="col-md-4 img-portfolio">
                                @php
                                    $banner = $activity->attachments->first(function ($key, $value) {
                                        return $value->category == 'banner';
                                    });

                                    $banner_path = !is_null($banner)
                                        ? asset('storage/banners/' . $banner->name)
                                        : 'https://placehold.it/1050x450';
                                @endphp
                                <a href="{{ route('visit::activity', [$activity]) }}">
                                        <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $activity->name }}">
                                </a>
                                <h3>
                                    <a href="{{ route('visit::activity', [$activity]) }}">
                                        {{ $activity->name }}
                                    </a>
                                </h3>
                                <p>
                                    活動時間：
                                    @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                        {{ $activity->start_time->toDateString() }}
                                         ~ 
                                        {{ $activity->end_time->toDateString() }}
                                    @else
                                        {{ $activity->start_time->toDateString() }}
                                    @endif
                                </p>
                                <p>{{ $activity->summary }}</p>
                            </div>
                            <div class="col-xs-12 text-center">
                                {!!
                                    $activities
                                        ->appends($url_query)
                                        ->appends('tab', 'activities')
                                        ->links()
                                !!}
                            </div>
                        @empty
                            <h3>目前沒有正在舉辦的活動</h3>
                            <br>
                            <a href="mailto:{{ $info->account->email }}" class="btn btn-primary">
                                通知主辦單位來辦活動吧 ! 
                            </a>
                        @endforelse
                    </div>
                    <div class="tab-pane fade {{ $tab == 'histories' ? 'active in' : '' }}" id="histories">
                        <br>
                        @forelse ($histories as $history)
                            <div class="col-md-4 img-portfolio">
                                @php
                                    $banner = $history->attachments->first(function ($key, $value) {
                                        return $value->category == 'banner';
                                    });

                                    $banner_path = !is_null($banner)
                                        ? asset('storage/banners/' . $banner->name)
                                        : 'https://placehold.it/1050x450';
                                @endphp
                                <a href="{{ route('visit::activity', [$history]) }}">
                                    <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $history->name }}">
                                </a>
                                <h3>
                                    <a href="{{ route('visit::activity', [$history]) }}">
                                        {{ $history->name }}
                                    </a>
                                </h3>
                                <p>
                                    活動時間：
                                    @if ($history->start_time->toDateString() != $history->end_time->toDateString())
                                        {{ $history->start_time->toDateString() }}
                                         ~ 
                                        {{ $history->end_time->toDateString() }}
                                    @else
                                        {{ $history->start_time->toDateString() }}
                                    @endif
                                </p>
                                <p>{{ $history->summary }}</p>
                            </div>
                            <div class="col-xs-12 text-center">
                                {!!
                                    $histories
                                        ->appends($url_query)
                                        ->appends('tab', 'histories')
                                        ->links()
                                !!}
                            </div>
                        @empty
                            <h3>目前沒有舉辦過的活動</h3>
                        @endforelse
                    </div>
                    <div class="tab-pane fade" id="about">
                        <br>
                        {!! $info->intro !!}
                    </div>
                    <div class="tab-pane fade" id="map">
                        <h3>
                            電子郵件：
                            <a href="mailto:{{ $info->account->email }}">{{ $info->account->email }}</a>
                        </h3>
                        <h3>市話：<a href="tel:{{ $info->phone }}">{{ $info->phone }}</a></h3>
                        <h3>手機：<a href="tel:{{ $info->mobile_phone }}">{{ $info->mobile_phone }}</a></h3>
                        @if (!empty($info->fax))
                            <h3>傳真：{{ $info->fax }}</h3>
                        @endif
                        <h3>住址：{{ $info->address }}</h3>
                        <iframe src="https://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $info->address }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

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