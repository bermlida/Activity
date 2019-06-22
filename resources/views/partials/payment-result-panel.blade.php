
    <!-- Payment Result -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">付款明細</h4>
        </div>
        <div class="panel-body">
            <p>訂單編號：{{ $transaction->payment_result->MerchantTradeNo }}</p>
            <p>交易金額：{{ $transaction->payment_result->TradeAmt }}</p>
            <p>付款時間：{{ $transaction->payment_result->PaymentDate }}</p>
        </div>
    </div>
    <!-- /.panel -->
