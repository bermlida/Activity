
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Features Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    檢視報名資訊
                </h2>
            </div>
            <div class="col-md-12">
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
            </div>
            @if (!is_null($transaction))
                @if ($transaction->status == 0 && !is_null($transaction->payment_info))
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
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
                @endif
                @if ($transaction->status == 1 && !is_null($transaction->payment_result))
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <p>訂單編號：{{ $transaction->payment_result->MerchantTradeNo }}</p>
                        <p>交易金額：{{ $transaction->payment_result->TradeAmt }}</p>
                        <p>付款金額：{{ $transaction->payment_result->PayAmt }}</p>
                        <p>付款時間：{{ $transaction->payment_result->PaymentDate }}</p>
                    </div>
                @endif
            @endif
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
