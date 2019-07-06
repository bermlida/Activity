<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitApplyFormRequest;
use App\Http\Requests\PostTransactionRequest;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\AllpayService;

class ActionController extends Controller
{
    /**
     * 新增報名活動的訂單資料。
     *
     * @return \Illuminate\Http\Response
     */
    public function postOrder($activity, SubmitApplyFormRequest $request)
    {
        $user = Auth::user()->profile;
        $activity = Activity::find($activity);
        
        $payment_amount = !$activity->is_free ? $activity->apply_fee : 0;
        if ($request->has('sponsorship_amount')) {
            $payment_amount += $request->input('sponsorship_amount');
        }

        do {
            $serial_number = ($payment_amount > 0) ? 'P' : 'F';
            $serial_number .= str_replace('-', '', Carbon::now()->toDateString());
            $serial_number .= strtoupper(str_random(6));
        } while (Order::where('serial_number', $serial_number)->count() > 0);

        $user->activities()->attach(
            $activity->id,
            [
                'serial_number' => $serial_number,
                'status' => ($payment_amount > 0 ? 0 : 1),
                'status_info' => ($payment_amount > 0 ? '報名未完成' : '已完成報名')
            ]
        );
        
        $data['serial_number'] = $serial_number;
        if ($payment_amount > 0) {
            $route = 'sign-up::payment::confirm';
            if (!$activity->is_free) {
                $data['apply_fee'] = $activity->apply_fee;
            }
            if ($request->has('sponsorship_amount')) {
                $data['sponsorship_amount'] = $request->input('sponsorship_amount');
            }
        } else {
            $route = 'sign-up::confirm';
        }
        
        return redirect()
                ->route($route, ['activity' => $activity->id])
                ->with($data);
    }

    /**
     * 更新報名活動的訂單資料。
     *
     * @return \Illuminate\Http\Response
     */
    public function putOrder($activity, $record, SubmitApplyFormRequest $request)
    {
        $activity = Activity::find($activity);
        
        $payment_amount = !$activity->is_free ? $activity->apply_fee : 0;
        if ($request->has('sponsorship_amount')) {
            $payment_amount += $request->input('sponsorship_amount');
        }
        
        $data['serial_number'] = $record;
        if ($payment_amount > 0) {
            $route = 'sign-up::payment::confirm';
            if (!$activity->is_free) {
                $data['apply_fee'] = $activity->apply_fee;
            }
            if ($request->has('sponsorship_amount')) {
                $data['sponsorship_amount'] = $request->input('sponsorship_amount');
            }
        } else {
            $route = 'sign-up::confirm';
        }
        
        return redirect()
                ->route($route, ['activity' => $activity->id])
                ->with($data);
    }

    /**
     * 新增訂單交易資料。
     *
     * @return string
     */
    public function postTransaction($activity, PostTransactionRequest $request)
    {
        $serial_number = session('serial_number');
        
        $order = Auth::user()
                    ->profile->activities()
                    ->wherePivot('serial_number', $serial_number)
                    ->first()->pivot;
        
        $order->transactions()->delete();

        do {
            $transaction_serial_number = $order->serial_number . strtoupper(str_random(5));
        } while (Transaction::where('serial_number', $transaction_serial_number)->count() > 0);

        $transaction = new Transaction([
            'serial_number' => $transaction_serial_number,
            'apply_fee' => $request->apply_fee,
            'sponsorship_amount' => $request->sponsorship_amount,
            'status' => 0,
            'status_info' => '未完成付款'
        ]);
        
        $order->transactions()->save($transaction);

        print app(AllpayService::class)->getCheckOut($order, $transaction);
    }

    /**
     * 更新訂單交易資料，儲存付款資訊。
     *
     * @return \Illuminate\Http\Response
     */
    public function savePaymentInfo(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');

        $transaction = Transaction::where('serial_number', $serial_number)->first();
        $transaction->payment_info = $request->all();
        $transaction->save();

        return redirect()
                ->route('sign-up::confirm', ['activity' => $transaction->order->activity->id])
                ->with([
                    'serial_number' => $transaction->order->serial_number,
                    'transaction_serial_number' => $serial_number
                ]);
    }

    /**
     * 更新訂單交易資料，儲存付款結果。
     *
     * @return \Illuminate\Http\Response
     */
    public function savePaymentResult(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');
        
        $transaction = Transaction::where('serial_number', $serial_number)->first();
        $transaction->payment_result = $request->all();
        $transaction->status = 1;
        $transaction->status_info = '已完成付款';
        $transaction->save();

        $order = $transaction->order;
        $order->status = 1;
        $order->status_info = '已完成報名';
        $order->save();
        
        return redirect()
            ->route('sign-up::confirm', ['activity' => $order->activity->id])
            ->with([
                'serial_number' => $order->serial_number,
                'transaction_serial_number' => $serial_number
            ]);
    }

    /**
     * 背景更新訂單交易資料，儲存付款結果。
     *
     * @return string
     */
    public function savePaymentResultDelay(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');
        
        $transaction = Transaction::where('serial_number', $serial_number)->first();
        $transaction->payment_result = $request->all();
        $transaction->status = 1;
        $transaction->status_info = '已完成付款';
        $transaction->save();

        $order = $transaction->order;
        $order->status = 1;
        $order->status_info = '已完成報名';
        $order->save();
        
        return '1|OK';
    }
}
