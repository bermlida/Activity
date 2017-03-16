<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitApplyFormRequest;
use App\Models\Activity;
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

        $transation = Transaction::where('serial_number', $serial_number)->first();
        
        $transation->payment_info = json_encode($request->all());

        $transation->save();

        return redirect()
            ->route('confirm', ['activity' => $transation->order->activity->id])
            ->with(['serial_number' => $transation->order->serial_number]);
    }

    public function savePaymentResult(Request $request)
    {
        $serial_number = $request->input('MerchantTradeNo');
        
        $transation = Transaction::where('serial_number', $serial_number)->first();

        $transation->payment_result = json_encode($request->all());

        $transation->save();

        return redirect()
            ->route('confirm', ['activity' => $transation->order->activity->id])
            ->with(['serial_number' => $transation->order->serial_number]);
    }
}
