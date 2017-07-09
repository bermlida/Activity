
    <!-- /.payment-info-panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">繳費資訊</h4>
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