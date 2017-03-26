
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
            <div class="item active">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Three');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
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
                            <a href="{{ url('/activity/' . $activity->id) }}">
                                {{ $activity->name }}
                            </a>
                        </h3>
                    </div>
                    <div class="panel panel-default">
                        <a href="{{ url('/activity/' . $activity->id) }}">
                            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
                        </a>
                        <div class="panel-body">
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
                            <a href="{{ url('/organizer/' . $organizer->id) }}">
                                {{ $organizer->name }}
                            </a>
                        </h3>
                    </div>
                    <div class="panel panel-default">
                        <a href="{{ url('/organizer/' . $organizer->id) }}">
                            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
                        </a>
                        <div class="panel-body">
                            <p>電話：{{ $organizer->phone }}</p>
                            <p>住址：{{ $organizer->address }}</p>
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
                    <a class="btn btn-lg btn-default btn-block" href="#">
                        聯絡客服人員
                    </a>
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