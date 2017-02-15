
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
            <div class="col-md-6 img-portfolio text-center">
                <a href="{{ url('/organizer/' . $organizer->id) }}">
                    <img class="img-responsive img-hover" src="http://placehold.it/750x450" alt="{{ $organizer->name }}">
                </a>
                <h3><a href="portfolio-item.html">{{ $organizer->name }}</a></h3>
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
