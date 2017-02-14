
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
