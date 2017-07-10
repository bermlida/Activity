
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">報名資訊</h4>
        </div>
        <div class="panel-body">
            <p>活動名稱：{{ $order->activity->name }}</p>
            <p>活動時間：
                @if ($order->activity->start_time->toDateString() != $order->activity->end_time->toDateString())
                    {{ $order->activity->start_time->toDateString() }}
                     ~ 
                    {{ $order->activity->end_time->toDateString() }}
                @else
                    {{ $order->activity->start_time->toDateString() }}
                @endif
            </p>
            <p>活動地點：{{ $order->activity->venue }}</p>
            <p>報名者姓名：{{ $order->user->name }}</p>
            <p>報名者電子郵件：{{ $order->user->account->email }}</p>
            <p>報名者手機：{{ $order->user->mobile_phone }}</p>
        </div>
    </div>
    <!-- /.apply-info-panel -->