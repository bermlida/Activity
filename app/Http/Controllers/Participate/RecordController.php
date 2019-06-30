<?php

namespace App\Http\Controllers\Participate;

use Auth;
use DB;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Output\QRImage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancialAccountRequest;
use App\Models\FinancialAccount;
use App\Models\Order;
use App\Services\AllpayService;

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
            ->launched()
            ->wherePivot('status', 1)
            ->paginate(10, ['*'], 'registered_page');

        $data['undone_activities'] = $user->activities()
            ->launched()
            ->wherePivot('status', 0)
            ->paginate(10, ['*'], 'undone_page');

        $data['cancelled_activities'] = $user->activities()
            ->launched()
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
        $data['order'] = Order::where('serial_number', $record)->first();

        $data['transaction'] = $data['order']->transactions()->first();

        return view('participate.record', $data);
    }

    /**
     * 顯示取消特定活動報名的確認畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showCancel($record)
    {
        $data['order'] = Order::where('serial_number', $record)->first();

        $data['transaction'] = $data['order']->transactions()->first();

        if (!is_null($data['transaction']) && !is_null($data['transaction']->payment_result)) {
            if (explode('_', $data['transaction']->payment_result->PaymentType)[0] != 'Credit') {
                $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
            
                if (!is_null($data['transaction']->financial_account)) {
                    $data['financial_account'] = $data['transaction']->financial_account;
                } else {
                    $data['financial_account'] = Auth::user()->profile->financial_account;
                }
            }
        }

        return view('participate.cancel', $data);
    }

    /**
     * 取消特定活動的報名紀錄。
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($record, Request $request)
    {
        $result = DB::transaction(function () use ($record, $request) {
            $cancel_status = ['status' => -1, 'status_info' => '使用者取消'];

            $order = Order::where('serial_number', $record)->first();

            $transaction = $order->transactions()->first();

            $order_result = $order->fill($cancel_status)->save();

            if (!is_null($transaction)) {
                $transaction_result = $transaction->fill($cancel_status)->save();

                if (!is_null($transaction->payment_result)) {
                    $segments = explode('_', $transaction->payment_result->PaymentType);

                    if ($segments[0] != 'Credit') {
                        if (is_null($transaction->financial_account)) {
                            $financial_account = new FinancialAccount($request->all());

                            $refund_result = $transaction->financial_account()->save($financial_account);
                        } else {
                            $refund_result = $transaction->financial_account->fill($request->all())->save();
                        }
                    } else {
                        //$result = app(AllpayService::class)->cancelCreditTrade($transaction);

                        //$refund_result = $result['RtnCode'] == 1;

                        $refund_result = true;
                    }

                    return $order_result && $transaction_result && $refund_result;
                }

                return $order_result && $transaction_result;
            }

            return $order_result;
        });

        return redirect()
                ->route('participate::record::cancel::confirm', ['record' => $record])
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

        $data['transaction'] = $data['order']->transactions()
                                    ->ofStatus(-1)
                                    ->whereNotNull('payment_result')
                                    ->first();

        $data['financial_account'] = $data['transaction']->financial_account;

        $data['taiwan_bank_codes'] = app('TaiwanBankCode')->listBankCodeATM();
        
        return view('participate.refund', $data);
    }

    /**
     * 特定活動的報名取消退款。
     *
     * @return \Illuminate\Http\Response
     */
    public function refund($record, StoreFinancialAccountRequest $request)
    {
        $order = Order::where('serial_number', $record)->first();

        $transaction = $order->transactions()->ofStatus(-1)->whereNotNull('payment_result')->first();

        $result = $transaction->financial_account->fill($request->all())->save();

        return redirect()
                ->route('participate::record::refund::confirm', ['record' => $record])
                ->with([
                    'message_type' => $result ? 'success' : 'warning',
                    'message_body' => $result ? '儲存成功' : '儲存失敗'
                ]);
    }
}
