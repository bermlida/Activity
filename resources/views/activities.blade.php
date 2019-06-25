
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">找活動</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Activities -->
        <div class="row">
            @forelse ($activities as $activity)
                <div class="col-md-4 img-portfolio">
                    <a href="{{ route('visit::activity', [$activity]) }}">
                        @php
                            $banner = $activity->attachments->first(function ($key, $value) {
                                return $value->category == 'banner';
                            });

                            $banner_path = !is_null($banner)
                                ? asset('storage/banners/' . $banner->name)
                                : 'http://placehold.it/1050x450';
                        @endphp
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
            @empty
                <div class="col-xs-12">
                    目前這裡還沒有活動
                </div>
            @endforelse
        </div>
        <!-- /.row -->

        <hr>

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-xs-12">
                {!! $activities->links() !!}
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
