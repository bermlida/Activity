
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    活動報名
                    <small>完成及確認</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-group">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                報名資訊
                            </h4>
                        </div>
                        <div class="panel-body">
                            <p>活動名稱：{{ $activity->name }}</p>
                            <p>活動時間：
                                @if ($carbon->parse($activity->start_time)->toDateString() != $carbon->parse($activity->end_time)->toDateString())
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                     ~ 
                                    {{ $carbon->parse($activity->end_time)->toDateString() }}
                                @else
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                @endif
                            </p>
                            <p>活動地點：{{ $activity->venue }}</p>
                            <p>報名者姓名：{{ $user_profile->name }}</p>
                            <p>報名者電子郵件：{{ $user_account->email }}</p>
                            <p>報名者手機：{{ $user_profile->mobile_phone }}</p>
                            @if (isset($transaction))
                                <hr>
                                @if ($transaction->apply_fee > 0)
                                    <p>報名費用：{{ $transaction->apply_fee }}</p>
                                @endif
                                @if ($transaction->sponsorship_amount > 0)
                                    <p>贊助金額：{{ $transaction->sponsorship_amount }}</p>
                                @endif
                                <p>
                                    報名費用總額：
                                    {{ $transaction->apply_fee + $transaction->sponsorship_amount }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if (isset($transaction) && !is_null($transaction->payment_info))
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    繳費資訊
                                </h4>
                            </div>
                            <div class="panel-body">
                                <p>訂單編號：{{ $transaction->payment_info->MerchantTradeNo }}</p>
                                <p>繳費金額：{{ $transaction->payment_info->TradeAmt }}</p>
                                @if (isset($transaction->payment_info->PaymentNo))
                                    <p>繳費代碼：{{ $transaction->payment_info->PaymentNo }}</p>
                                @endif
                                @if (isset($transaction->payment_info->BankCode))
                                    <p>繳費銀行代碼：{{ $transaction->payment_info->BankCode }}</p>
                                @endif
                                @if (isset($transaction->payment_info->vAccount))
                                    <p>繳費虛擬帳號：{{ $transaction->payment_info->vAccount }}</p>
                                @endif
                                <p>繳費期限：{{ $transaction->payment_info->ExpireDate }}</p>
                            </div>
                        </div>
                    @endif
                    @if (isset($transaction) && !is_null($transaction->payment_result))
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    交易明細
                                </h4>
                            </div>
                            <div class="panel-body">
                                <p>訂單編號：{{ $transaction->payment_result->MerchantTradeNo }}</p>
                                <p>交易金額：{{ $transaction->payment_result->TradeAmt }}</p>
                                <p>付款金額：{{ $transaction->payment_result->PayAmt }}</p>
                                <p>付款時間：{{ $transaction->payment_result->PaymentDate }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h3>看看現在報名了那些活動</h3>
                <a href="{{ url('/participate/activities') }}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
                    立刻查看
                </a>
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