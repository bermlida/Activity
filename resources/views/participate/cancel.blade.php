
@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">取消報名</h1>
            </div>
        </div>
        <!-- /.row -->

        <form role="form" method="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel-group">
                        @include('partials.apply-info-panel')
                    
                        @if (!is_null($transaction))
                            @include('partials.apply-fee-info-panel')

                            @if (!is_null($transaction->payment_result))
                                @include('partials.payment-result-panel')

                                @if ($transaction->apply_fee > 0)

                                    <!-- Refund Account -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">退款設定</h4>
                                        </div>
                                        <div class="panel-body">
                                            @include('partials.financial-institution-account-form')
                                        </div>
                                    </div>
                                    <!-- /.panel -->

                                @endif
                            @elseif (!is_null($transaction->payment_info))
                                @include('partials.payment-info-panel')
                            @endif
                        @endif
                    </div>
                    <!-- /.panel-group -->
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <a href="javascript:history.back(-1);" class="btn btn-danger">
                                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                返回
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                確認取消
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </form>

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
