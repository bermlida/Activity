
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    找活動
                    <small>開啟自性之旅</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Service Panels -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
        <div class="row">
            @forelse ($activities as $activity)
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="http://placehold.it/700x400" alt="">
                    </a>
                    <h3><a href="{{ url('/activity/' . $activity->id) }}">
                        {{ $activity->name }}
                    </a></h3>
                    <p>{{ $activity->summary }}</p>
                </div>
            @empty
                <div class="col-md-12">
                    目前這裡還沒有活動
                </div>
            @endforelse
{{--
            @forelse ($activities as $activity)
                <div class="col-md-3 col-sm-6">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <img class="img-responsive" src="http://placehold.it/1200x300" alt="">
                        </div>
                        <div class="panel-body">
                            <h4>{{ $activity->name }}</h4>
                            <p>{{ $activity->summary }}</p>
                            <a href="{{ url('/activity/' . $activity->id) }}" class="btn btn-primary">了解詳情</a>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
--}}
        </div>
        <!-- /.row -->

        <hr>

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li>
                        @if (!is_null($activities->previousPageUrl()))
                            <a href="{{ $activities->previousPageUrl() }}">&laquo;</a>
                        @else
                            <a href="#">&laquo;</a>
                        @endif
                    </li>
                    @for ($i = 1 ; $i <= $activities->lastPage() ; $i++)
                        @if ($i == $activities->currentPage())
                            <li class="active"><a href="#">{{ $i }}</a></li>
                        @else
                            <li><a href="{{ $activities->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    <li>
                        @if (!is_null($activities->nextPageUrl()))
                            <a href="{{ $activities->nextPageUrl() }}">&raquo;</a>
                        @else
                            <a href="#">&raquo;</a>
                        @endif
                    </li>
                </ul>
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
