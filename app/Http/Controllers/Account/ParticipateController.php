<?php

namespace App\Http\Controllers\Account;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order;

class ParticipateController extends Controller
{
    /**
     * 顯示使用者參加活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = (Auth::user())->profile;

        $data['registered_activities'] = $user->activities()->wherePivot('status', 1)->get();

        $data['undone_activities'] = $user->activities()->wherePivot('status', 0)->get();

        $data['cancelled_activities'] = $user->activities()->wherePivot('status', -1)->get();
        
        return view('account.participate-records', $data);
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

        $data['user_account'] = $order->user->account()->first();

        $data['user_profile'] = $order->user;

        return view('account.participate-record', $data);
    }

    /**
     * 取消特定活動的報名紀錄。
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($record)
    {
        $order = Order::where('serial_number', $record)->first();

        $order->status = -1;

        $order->status_info = '使用者取消';

        $data['result'] = $order->save();

        $data['message'] = $data['result'] ? '取消成功' : '取消失敗';

        return response()->json($data);
    }
}
