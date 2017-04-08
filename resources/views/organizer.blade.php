
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Image Header -->
        <div class="row">
            <br>
            <div class="col-lg-12">
                <img class="img-responsive" src="{{ !is_null($banner) ? asset('storage/banners/' . $banner->name) : 'http://placehold.it/1200x300' }}" alt="{{ $info->name }}">
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
            <div class="col-lg-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="">
                        <a href="#activities" data-toggle="tab">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            當前活動
                        </a>
                    </li>
                    <li class="">
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
                    <li class="active">
                        <a href="#about" data-toggle="tab">
                            <i class="fa fa-tree" aria-hidden="true"></i>
                            關於
                        </a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade" id="activities">
                        @forelse ($activities as $activity)
                            <div class="col-md-3 img-portfolio">
                                @php
                                    $banner = $activity->attachments->first(function ($key, $value) {
                                        return $value->category == 'banner';
                                    });

                                    $banner_path = !is_null($banner)
                                        ? asset('storage/banners/' . $banner->name)
                                        : 'http://placehold.it/750x450';
                                @endphp
                                <a href="{{ route('visit::activity', [$activity]) }}">
                                    <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $activity->name }}">
                                </a>
                                <p>
                                    <a href="{{ route('visit::activity', [$activity]) }}">
                                        {{ $activity->name }}
                                    </a>
                                </p>
                                <p>
                                    活動時間：
                                    @if ($carbon->parse($activity->start_time)->toDateString() != $carbon->parse($activity->end_time)->toDateString())
                                        {{ $carbon->parse($activity->start_time)->toDateString() }}
                                         ~ 
                                        {{ $carbon->parse($activity->end_time)->toDateString() }}
                                    @else
                                        {{ $carbon->parse($activity->start_time)->toDateString() }}
                                    @endif
                                </p>
                            </div>
                        @empty
                            <h3>目前沒有正在舉辦的活動</h3>
                            <br>
                            <a href="mailto:{{ $info->account->first()->email }}" class="btn btn-primary">
                                通知主辦單位來辦活動吧 ! 
                            </a>
                        @endforelse
                    </div>
                    <div class="tab-pane fade" id="histories">
                        @forelse ($histories as $history)
                            <div class="col-md-3 img-portfolio">
                                @php
                                    $banner = $history->attachments->first(function ($key, $value) {
                                        return $value->category == 'banner';
                                    });

                                    $banner_path = !is_null($banner)
                                        ? asset('storage/banners/' . $banner->name)
                                        : 'http://placehold.it/750x450';
                                @endphp
                                <a href="{{ route('visit::activity', [$history]) }}">
                                    <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $history->name }}">
                                </a>
                                <p>
                                    <a href="{{ route('visit::activity', [$history]) }}">
                                        {{ $history->name }}
                                    </a>
                                </p>
                                <p>
                                    活動時間：
                                    @if ($carbon->parse($history->start_time)->toDateString() != $carbon->parse($history->end_time)->toDateString())
                                        {{ $carbon->parse($history->start_time)->toDateString() }}
                                         ~ 
                                        {{ $carbon->parse($history->end_time)->toDateString() }}
                                    @else
                                        {{ $carbon->parse($history->start_time)->toDateString() }}
                                    @endif
                                </p>
                            </div>
                        @empty
                            <h3>目前沒有舉辦過的活動</h3>
                        @endforelse
                    </div>
                    <div class="tab-pane fade active in" id="about">
                        {{ $info->intro }}
                    </div>
                    <div class="tab-pane fade" id="map">
                        <h3>電話：{{ $info->phone }}</h3>
                        @if (!empty($info->fax))
                            <h3>傳真：{{ $info->fax }}</h3>
                        @endif
                        @if (!empty($info->mobile_phone))
                            <h3>手機：{{ $info->mobile_phone }}</h3>
                        @endif
                        <h3>住址：{{ $info->address }}</h3>
                        <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $info->address }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
        </div>

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