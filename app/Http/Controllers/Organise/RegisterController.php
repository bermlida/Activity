<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * 更新報到狀態。
     *
     * @return \Illuminate\Http\Response
     */
    public function scan()
    {
        return view('organise.register-certificate-scan');
    }
    
    /**
     * 。
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
     * 。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity, $certificate)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $data['order'] = $activity->orders()->where('serial_number', $certificate)->first();

        return view('organise.register-info', $data);
    }
}
