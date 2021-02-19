
@extends('layouts.main')

@section('content')

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach ($random_activities as $key => $activity)
                <div class="item {{ $key == 0 ? 'active' : '' }}">
                    @php
                        $banner = $activity->attachments->first(function ($key, $value) {
                            return $value->category == 'banner';
                        });

                        $banner_path = !is_null($banner)
                            ? $banner->secure_url
                            : 'https://placehold.it/1050x450';
                    @endphp
                    <div class="fill" style="background-image:url('{{ $banner_path }}');"></div>
                    <div class="carousel-caption">
                        <h2>{{ $activity->name }}</h2>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    最新活動
                </h1>
            </div>

            @forelse ($activities as $activity)
                <div class="col-md-4">
                    <div class="panel-heading">
                        <h3>
                            <a href="{{ route('visit::activity', [$activity]) }}">
                                {{ $activity->name }}
                            </a>
                        </h3>
                    </div>
                    <div class="panel panel-default">
                        @php  
                            $banner = $activity->attachments->first(function ($key, $value) {
                                return $value->category == 'banner';
                            });

                            $banner_path = !is_null($banner)
                                ? $banner->secure_url
                                : 'https://placehold.it/1050x450';
                        @endphp
                        <a href="{{ route('visit::activity', [$activity]) }}">
                            <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $activity->name }}">
                        </a>
                        <div class="panel-body">
                            <p>
                                活動時間：
                                {{ $activity->start_time->format('Y-m-d H:i') }}
                                 ~ 
                                {{ $activity->end_time->format('Y-m-d H:i') }}
                            </p>
                            <p>活動地點：{{ $activity->venue }}</p>
                            <p>{{ $activity->summary }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <h2>目前無活動可供檢索</h2>
                </div>
            @endforelse
        </div>
        <!-- /.row -->

        <!-- Portfolio Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    新加入的主辦單位
                </h2>
            </div>

            @forelse ($organizers as $organizer)
                <div class="col-md-4">
                    <div class="panel-heading">
                        <h3>
                            <a href="{{ route('visit::organizer', [$organizer]) }}">
                                {{ $organizer->name }}
                            </a>
                        </h3>
                    </div>
                    <div class="panel panel-default">
                        @php
                            $banner = $organizer->attachments->first(function ($key, $value) {
                                return $value->category == 'banner';
                            });

                            $banner_path = !is_null($banner)
                                ? $banner->secure_url
                                : 'https://placehold.it/750x450';
                        @endphp
                        <a href="{{ route('visit::organizer', [$organizer]) }}">
                            <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $organizer->name }}">
                        </a>
                        <div class="panel-body">
                            <p>
                                市話：
                                <a href="tel:{{ $organizer->phone }}">
                                    {{ $organizer->phone }}
                                </a>
                            </p>
                            <p>
                                手機：
                                <a href="tel:{{ $organizer->mobile_phone }}">
                                    {{ $organizer->mobile_phone }}
                                </a>
                            </p>
                            <p>
                                電子郵件：
                                <a href="mailto:{{ $organizer->account->email }}">
                                    {{ $organizer->account->email }}
                                </a>
                            </p>
                            <p>
                                住址：
                                <a href="https://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $organizer->address }}" target="view_window">
                                    {{ $organizer->address }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <h2>目前無主辦單位可供檢索</h2>
                </div>
            @endforelse
        </div>
        <!-- /.row -->

        <hr>

        <!-- Call to Action Section -->
        <div class="well">
            <div class="row">
                <div class="col-md-8">
                    <h2>需要協助或洽談合作 ? </h2>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-default btn-block" href="mailto:admin@test.com">
                        聯絡客服人員
                    </a>
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