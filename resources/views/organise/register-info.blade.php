
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Feature Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    報到資訊
                </h2>
            </div>
            <div class="col-md-12">
                <div class="panel-group">
                    
                    @include('partials.apply-info-panel')
                    
                </div>
                <!-- /.panel-group -->
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