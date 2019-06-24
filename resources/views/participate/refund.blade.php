
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

        <!-- Refund Account Setting -->
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" role="form" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('partials.financial-institution-account-form')

                    <div class="form-group">
                        <div class="col-xs-5 col-xs-offset-2">
                            <a href="javascript:history.back(-1);" class="btn btn-danger">
                                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                返回
                            </a>
                        </div>
                        <div class="col-xs-5">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                存檔
                            </button>
                        </div>
                    </div>                    
                </form>
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

@endsection