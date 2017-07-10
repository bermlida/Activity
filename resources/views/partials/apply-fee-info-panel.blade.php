
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">付款資訊</h4>
        </div>
        <div class="panel-body">
            @if ($transaction->apply_fee > 0)
                <p>報名費用：{{ $transaction->apply_fee }}</p>
            @endif
            @if ($transaction->sponsorship_amount > 0)
                <p>贊助金額：{{ $transaction->sponsorship_amount }}</p>
            @endif
            <p>
                支付費用總額：
                {{ $transaction->apply_fee + $transaction->sponsorship_amount }}
            </p>
        </div>
    </div>
    <!-- /.apply-fee-info-panel -->