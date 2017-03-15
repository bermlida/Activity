<?php

namespace App\Services;

// use Allpay;
// use DB;
// use PaymentMethod;
// use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;
use App\Models\Order;

class AllpayService
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * 。
     *
     * @return string
     */
    public function getCheckOutForm(Order $order)
    {
        $allpay = app('allpay')->instance();
        $allpay->Send['MerchantTradeNo'] = $order->serial_number . strtoupper(str_random(5));
        $allpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $allpay->Send['TotalAmount'] = session('payment_amount');
        $allpay->Send['TradeDesc'] = $order->activity->name;
        $allpay->Send['ChoosePayment'] = \PaymentMethod::ALL;

        $allpay->Send['ReturnURL'] = url('/sign-up/' . $order->activity->id . '/payment');
        $allpay->Send['OrderResultURL'] = url('/sign-up/' . $order->activity->id . '/payment');
        $allpay->SendExtend['ClientRedirectURL'] = url('/sign-up/' . $order->activity->id . '/payment-info');

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

        return $allpay->CheckOutString('submit', '_self');
    }
}
