
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    活動報名
                    <small>確認付款資料</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="panel-group" id="accordion">
                    @include('partials.apply-info-panel')

                    <!-- Payment Info -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">付款資訊</h4>
                        </div>
                        <div class="panel-body">
                            @if (isset($apply_fee))
                                <p>報名費用：{{ $apply_fee }}</p>
                            @endif
                            @if (isset($sponsorship_amount))
                                <p>贊助金額：{{ $sponsorship_amount }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- /.panel -->
                    
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6 col-xs-6">
                <a href="{{ route('sign-up::apply::edit', ['activity' => $order->activity->id, 'serial_number' => $serial_number]) }}" class="btn btn-danger">
                    <i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
                    上一步
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <form role="form" method="POST" action="{{ route('sign-up::payment::deal', [$order->activity]) }}">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="apply_fee" value="{{ isset($apply_fee) ? $apply_fee : 0 }}">
                    <input type="hidden" name="sponsorship_amount" value="{{ isset($sponsorship_amount) ? $sponsorship_amount : 0 }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="glyphicon glyphicon-usd" aria-hidden="true"></i>
                        付款
                    </button>
                </form>
            </div>
        </div>

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
