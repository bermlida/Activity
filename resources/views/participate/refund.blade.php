
@extends('layouts.main')

@section('style')

    

@endsection

@section('content')

    <div class="container">
    
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <!-- Success/Fail Message -->
                @include('partials.alert-message')

                <h1 class="page-header">
                    退款設定
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('partials.refund-account')

                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="javascript:history.back(-1);" class="btn btn-danger">
                                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                返回
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
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

@section('script')

    

@endsection