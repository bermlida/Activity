
@extends('layouts.main')

@section('content')

    <div class="container">
        
        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">收款設定</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('account::receipt-setting::save') }}">
                {{ csrf_field() }}
                        
                @include('partials.financial-institution-account-form')

                <div class="form-group">
                    <div class="col-xs-6 col-sm-offset-5 col-xs-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                            存檔
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                @include('partials.copyright-notice')
            </div>
        </footer>
    </div>

@endsection
