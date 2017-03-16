<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use DB;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Transaction;
use App\Services\AllpayService;

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

        $transaction = new Transaction([
            'serial_number' => $order->serial_number . strtoupper(str_random(5)),
            'apply_fee' => session()->has('apply_fee') ? session('apply_fee') : 0,
            'sponsorship_amount' => session()->has('sponsorship_amount') ? session('sponsorship_amount') : 0,
            'status' => 0,
            'status_info' => '未完成付款'
        ]);
        // var_dump($order->transactions()->toSql()); exit;
        $order->transactions()->save($transaction);
        
        $data = session()->all();

        $data['user_account'] = $order->user->account()->first();

        $data['user_profile'] = $order->user;
        
        $data['activity'] = $order->activity;

        $data['post_form'] = app(AllpayService::class)->getCheckOutForm($order, $transaction);

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
