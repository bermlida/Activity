<?php

namespace App\Http\Controllers\SignUp;

use Allpay;
use Auth;
use DB;
use PaymentMethod;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Activity;

class StepController extends Controller
{
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
    public function showApplyForm($activity)
    {
        $data['activity'] = Activity::find($activity);

        $data['user_account'] = Auth::user();

        $data['user_profile'] = $data['user_account']->profile;
        
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

        $allpay = app('allpay')->instance();
        $allpay->Send['MerchantTradeNo'] = $serial_number . strtoupper(str_random(5));
        $allpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $allpay->Send['TotalAmount'] = session('payment_amount');
        $allpay->Send['TradeDesc'] = $order->activity->name;
        $allpay->Send['ChoosePayment'] = PaymentMethod::ALL;

        $allpay->Send['ReturnURL'] = 'http://activity.app/payment?page=return_url';
        $allpay->Send['OrderResultURL'] = 'http://activity.app/payment?page=order_result_url';
        $allpay->SendExtend['ClientRedirectURL'] = 'http://activity.app/payment?page=client_redirect_url';

        if (session()->has('apply_fee')) {
            $allpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 報名費用',
                'Price' => session('apply_fee'),
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => 'localhost'
            ];
        }

        if (session()->has('sponsorship_amount')) {
            $allpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 贊助金額',
                'Price' => session('sponsorship_amount'),
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => 'localhost'
            ];
        }

        $order = Auth::user()
            ->profile->activities()
            ->wherePivot('serial_number', $serial_number)
            ->first()->pivot;
        
        $data = session()->all();

        $data['user_account'] = $order->user->account()->first();

        $data['user_profile'] = $order->user;
        
        $data['activity'] = $order->activity;

        $data['post_form'] = $allpay->CheckOutString('submit', '_self');

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

        DB::table('orders')
            ->where('serial_number', $serial_number)
            ->update(['status' => 1, 'status_info' => '已完成報名']);

        $order = Auth::user()
            ->profile->activities()
            ->wherePivot('serial_number', $serial_number)
            ->first()->pivot;
        
        $data['order'] = $order;
        
        $data['user_account'] = $order->user->account()->first();

        $data['user_profile'] = $order->user;
        
        $data['activity'] = $order->activity;
        
        return view('sign-up.confirm', $data);
    }
}
