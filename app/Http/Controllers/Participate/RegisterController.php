<?php

namespace App\Http\Controllers\Participate;

use Auth;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Output\QRImage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order;

class RegisterController extends Controller
{
    /**
     * 顯示報到憑證(QR Code)的畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index($record)
    {
        $data['order'] = Order::where('serial_number', $record)->first();

        $data['transaction'] = $data['order']->transactions()->first();

        $data['qr_code'] = (new QRCode())->render($record);

        return view('participate.register-certificate', $data);
    }
}
