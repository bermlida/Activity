<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitApplyFormRequest;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Transaction;

class ActionController extends Controller
{
    /**
     * 。
     *
     * @return \Illuminate\Http\Response
     */
    public function submitApplyForm($activity, SubmitApplyFormRequest $request)
    {
        $user = Auth::user()->profile;

        $activity = Activity::find($activity);
        
        $payment_amount = !$activity->is_free ? $activity->apply_fee : 0;
        if ($request->has('sponsorship_amount')) {
            $payment_amount += $request->input('sponsorship_amount');
        }

        $serial_number = ($payment_amount > 0 ? 'P' : 'F');
        $serial_number .= str_replace('-', '', Carbon::now()->toDateString());
        $serial_number .= strtoupper(str_random(6));

        $user->activities()->attach(
            $activity->id,
            [
                'serial_number' => $serial_number,
                'status' => 0,
                'status_info' => '報名未完成'
            ]
        );
        
        $data['serial_number'] = $serial_number;
        if ($payment_amount > 0) {
            $route = 'payment';
            if (!$activity->is_free) {
                $data['apply_fee'] = $activity->apply_fee;
            }
            if ($request->has('sponsorship_amount')) {
                $data['sponsorship_amount'] = $request->input('sponsorship_amount');
            }
            $data['payment_amount'] = $payment_amount;
        } else {
            $route = 'confirm';
        }
        
        return redirect()
            ->route($route, ['activity' => $activity->id])
            ->with($data);
    }

    public function savePaymentInfo(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');

        $transaction = Transaction::where('serial_number', $serial_number)->first();
        $transaction->payment_info = json_encode($request->all());
        $transaction->save();

        $order = DB::table('orders')->where('serial_number', $transaction->order_serial_number)->first();

        return redirect()
            ->route('confirm', ['activity' => $order->activity->id])
            ->with(['serial_number' => $order->serial_number]);
    }

    public function savePaymentResult(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');
        
        $transaction = Transaction::where('serial_number', $serial_number)->first();
        $transaction->payment_result = json_encode($request->all());
        $transaction->status = 1;
        $transaction->status_info = '已完成付款';
        $transaction->save();

        // $order = Auth::user()
        //     ->profile->activities()
        //     ->wherePivot('serial_number', $serial_number)
        //     ->first()->pivot;

        DB::table('orders')
            ->where('serial_number', $transaction->order_serial_number)
            ->update(['status' => 1, 'status_info' => '已完成報名']);

        $order = DB::table('orders')->where('serial_number', $transaction->order_serial_number)->first();
        var_dump($order); exit;
        return redirect()
            ->route('confirm', ['activity' => $order->activity->id])
            ->with(['serial_number' => $order->serial_number]);
    }
}
