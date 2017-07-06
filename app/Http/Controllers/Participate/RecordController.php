<?php

namespace App\Http\Controllers\Participate;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialAccount;
use App\Models\Order;

class RecordController extends Controller
{
    /**
     * 顯示使用者參加活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = (Auth::user())->profile;

        $data['registered_activities'] = $user->activities()
            ->wherePivot('status', 1)
            ->paginate(10, ['*'], 'registered_page');

        $data['undone_activities'] = $user->activities()
            ->wherePivot('status', 0)
            ->paginate(10, ['*'], 'undone_page');

        $data['cancelled_activities'] = $user->activities()
            ->wherePivot('status', -1)
            ->paginate(10, ['*'], 'cancelled_page');

        $data['url_query'] = $request->only('registered_page', 'undone_page', 'cancelled_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'registered';
        
        return view('participate.records', $data);
    }

    /**
     * 顯示特定活動的報名紀錄。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($record)
    {
        $order = Order::where('serial_number', $record)->first();

        $data['order'] = $order;

        $data['activity'] = $order->activity;

        $data['user_account'] = $order->user->account;

        $data['user_profile'] = $order->user;

        return view('participate.record', $data);
    }

    /**
     * 顯示取消特定活動報名的確認畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showCancel($record)
    {
        $order = Order::where('serial_number', $record)->first();

        $transaction = $order->transactions()->where('status', 1)->first();

        if (!is_null($transaction)) {
            $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
            
            if (!is_null($transaction->financial_account)) {
                $data['financial_account'] = $transaction->financial_account;
            }
        }

        $data['order'] = $order;

        $data['activity'] = $order->activity;

        $data['user_account'] = $order->user->account;

        $data['user_profile'] = $order->user;

        return view('participate.cancel', $data);
    }

    /**
     * 取消特定活動的報名紀錄。
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($record, Request $request)
    {
        $order = Order::where('serial_number', $record)->first();

        $transaction = $order->transactions()->where('status', 1)->first();

        $result = $order->fill(['status' => -1, 'status_info' => '使用者取消'])->save();

        if (!is_null($transaction)) {
            $financial_account = new FinancialAccount($request->all());

            $refund_result = $transaction->financial_account()->save($financial_account);

            $result = $result && $refund_result;
        }

        return redirect()
                ->route('participate::record::cancel::confirm', ['record' => $order->serial_number])
                ->with([
                    'message_type' => $result ? 'success' : 'warning',
                    'message_body' => $result ? '取消成功' : '取消失敗'
                ]);
    }

    /**
     * 顯示退款設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showRefund($record)
    {
        $data['order'] = Order::where('serial_number', $record)->first();

        $data['transaction'] = $data['order']->transactions()->where('status', 1)->first();

        $data['financial_account'] = $data['transaction']->financial_account;

        $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
        
        return view('participate.refund', $data);
    }

    /**
     * 特定活動的報名取消退款。
     *
     * @return \Illuminate\Http\Response
     */
    public function refund($record, Request $request)
    {
        $order = Order::where('serial_number', $record)->first();

        $transaction = $order->transactions()->where('status', 1)->first();

        $financial_account = $transaction->financial_account;

        $result = $financial_account->fill($request->all())->save();

        return redirect()
                ->route('participate::record::refund::confirm', ['record' => $order->serial_number])
                ->with([
                    'message_type' => $result ? 'success' : 'warning',
                    'message_body' => $result ? '儲存成功' : '儲存失敗'
                ]);
    }
}
