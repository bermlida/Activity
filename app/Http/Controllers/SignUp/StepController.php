<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Transaction;

class StepController extends Controller
{
    protected $allpay_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * 顯示填寫報名資料的表單畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplyForm($activity, $serial_number = null)
    {
        if (!is_null($serial_number)) {
            $order = Auth::user()
                ->profile->activities()
                ->wherePivot('serial_number', $serial_number)
                ->first()->pivot;

            $data['activity'] = $order->activity;
            $data['user_account'] = $order->user->account()->first();
            $data['user_profile'] = $order->user;
            $data['form_method'] = 'PUT';
        } else {
            $data['activity'] = Activity::find($activity);
            $data['user_account'] = Auth::user();
            $data['user_profile'] = $data['user_account']->profile;
            $data['form_method'] = 'POST';
        }
        
        return view('sign-up.apply-form', $data);
    }

    /**
     * 顯示填選付款設定的表單畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function showPayment($activity)
    {
        $serial_number = session('serial_number');

        $order = Auth::user()
            ->profile->activities()
            ->wherePivot('serial_number', $serial_number)
            ->first()->pivot;
        
        $data = session()->all();

        $data['user_account'] = $order->user->account()->first();

        $data['user_profile'] = $order->user;
        
        $data['activity'] = $order->activity;

        return view('sign-up.payment', $data);
    }

    /**
     * 。
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirm()
    {
        $serial_number = session('serial_number');

        $data['order'] = Auth::user()
            ->profile->activities()
            ->wherePivot('serial_number', $serial_number)
            ->first()->pivot;

        if (session()->has('transaction_serial_number')) {
            $data['transaction'] = $data['order']
                ->transactions()
                ->where('serial_number', session('transaction_serial_number'))
                ->first();

            if (!is_null($data['transaction']->payment_info)) {
                $data['transaction']->payment_info = json_decode($data['transaction']->payment_info);
            }

            if (!is_null($data['transaction']->payment_result)) {
                $data['transaction']->payment_result = json_decode($data['transaction']->payment_result);
            }
        }
        
        $data['activity'] = $data['order']->activity;
        
        $data['user_account'] = $data['order']->user->account()->first();

        $data['user_profile'] = $data['order']->user;
        
        return view('sign-up.confirm', $data);
    }
}