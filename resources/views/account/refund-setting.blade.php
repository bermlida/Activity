
@extends('layouts.main')

@section('content')

    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">退款設定</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('account::refund-setting::save') }}">
                    {{ csrf_field() }}
                        
                    @include('partials.financial-institution-account-form')

                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-6 col-xs-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                存檔
                            </button>
                        </div>
                    </div>
                </form>
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

@endsection
