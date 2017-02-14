
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    找主辦單位
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Team Members -->
        <div class="row">
            @forelse ($organizers as $organizer)
                <div class="col-md-4 text-center">
                    <div class="thumbnail">
                        <img class="img-responsive" src="http://placehold.it/750x450" alt="">
                        <div class="caption">
                            <h3>{{ $organizer->name }}</h3><br>
                            <a href="{{ url('/organizer/' . $organizer->id) }}" class="btn btn-primary btn-lg btn-block">查看</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <h2>目前無主辦單位可供查詢</h2>
                </div>
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
