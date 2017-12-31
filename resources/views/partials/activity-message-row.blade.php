
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $message->subject }}</td>
        <td>{{
            implode(', ', array_map(function ($value) {
                switch ($value) {
                    case 'email': return 'E-Mail';
                    case 'sms': return '簡訊';
                    default: break;
                }    
            }, $message->sending_method))
        }}</td>
        <td>{{
            implode(', ', array_map(function ($value) {
                switch ($value) {
                    case 1: return '已完成報名';
                    case 0: return '未完成報名';
                    case -1: return '已取消報名';
                    default: break;
                }    
            }, $message->sending_target))
        }}</td>
        <td>{{ !is_null($message->sending_time) ? $message->sending_time->format('Y-m-d H:i') : '' }}</td>
        <td>
            @if ($message->status == 1)
                @if (!is_null($message->sending_time) && $message->sending_time >= $carbon->now()->format('Y-m-d H:i'))
                    <button type="button" class="btn btn-danger" onclick="update('{{ route('organise::activity::message::cancel', [$message->activity, $message]) }}')">取消發送</button>
                @endif
            @elseif ($message->status == 0)
                <a class="btn btn-info" href="{{
                    route('organise::activity::message::modify', [$message->activity, $message])
                }}" role="button">編輯</a>
                <button type="button" class="btn btn-danger" onclick="remove('{{ route('organise::activity::message::delete', [$message->activity, $message]) }}')">刪除</button>
            @endif
        </td>
    </tr>

