
@extends('layouts.main')

@section('style')

    

@endsection

@section('content')

    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                @if (!is_null(session('message_type')) && !is_null(session('message_body')))
                    <div class="alert alert-{{ session('message_type') }}" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        {{ session('message_body') }}
                    </div>
                @endif
                <h1 class="page-header">
                    退款設定
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('account::refund-setting::save') }}">
                    {{ csrf_field() }}
                        
                    @include('partials.refund-account-form')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-6">
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