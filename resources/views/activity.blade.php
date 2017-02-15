
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">
    
        <!-- Image Header -->
        <div class="row">
            <br>
            <div class="col-lg-12">
                <img class="img-responsive" src="http://placehold.it/1200x300" alt="">
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="text-align:center;">
                    {{ $activity->name }}
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <div class="row">
            <div class="col-md-6">
                <h3>活動時間：
                @if ($carbon->parse($activity->start_time)->toDateString() != $carbon->parse($activity->end_time)->toDateString())
                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                     ~ 
                    {{ $carbon->parse($activity->end_time)->toDateString() }}
                @else
                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                @endif
                </h3>
                <h3>活動地點：{{ $activity->venue }}</h3>
            </div>
            <div class="col-md-6">
                @if (!empty($activity->venue_intro))
                    <h4>{{ $activity->venue_intro }}</h4>
                    <h4>({{ $activity->venue }})</h4>
                @endif
                <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $activity->venue }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <!-- /.row -->

        <!-- Our Customers -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-header">活動介紹</h2>
            </div>
            <div class="col-md-12">
                {!! $activity->intro !!}
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