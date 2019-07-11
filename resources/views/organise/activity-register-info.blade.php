
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">報到資訊</h1>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <div class="col-xs-12">
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
                @include('partials.copyright-notice')
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection
