<?php

namespace App\Http\Controllers\SignUp;

use Auth;
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
        $data['activity'] = Activity::find($activity);

        return view('activity', $data);
    }

    /**
     * 。
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirm()
    {
        $serial_number = session('serial_number');

        $user = Auth::user()->profile;
        
        $order = $user->activities()
            ->wherePivot('serial_number', $serial_number)
            ->update(['status' => 1, 'status_info' => '已完成報名'])
            ->updateExistingPivot();
        // var_dump($order->serial_number);exit();
        // $order->fill(['status' => 1, 'status_info' => '已完成報名']);
        
        // $order->save();
        
        return view('sign-up.confirm', ['order' => $order]);
    }
}
