<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityRegisterController extends Controller
{
    /**
     * 顯示掃描報到憑證的掃描畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function scan()
    {
        return view('organise.activity-register-certificate-scan');
    }
    
    /**
     * 更新報到狀態。
     *
     * @return \Illuminate\Http\Response
     */
    public function use($activity, $certificate)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $order = $activity->orders()->where('serial_number', $certificate)->first();

        $order->fill(['register_status' => 1])->save();

        return response()->json($order);
    }

    /**
     * 顯示報到資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity, $certificate)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $data['order'] = $activity->orders()->where('serial_number', $certificate)->first();

        return view('organise.activity-register-info', $data);
    }
}
