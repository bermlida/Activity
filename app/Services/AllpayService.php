<?php

namespace App\Services;

// use Allpay;
// use DB;

use App\Models\Order;
use App\Models\Transaction;

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
    public function getCheckOutForm(Order $order, Transaction $transation)
    {
        $allpay = app('allpay')->instance();
        $allpay->Send['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $allpay->Send['TotalAmount'] = $transation->apply_fee + $transation->sponsorship_amount;
        $allpay->Send['TradeDesc'] = $order->activity->name;
        $allpay->Send['ChoosePayment'] = \PaymentMethod::ALL;

        $allpay->Send['ReturnURL'] = url('/sign-up/' . $order->activity->id . '/payment');
        $allpay->Send['OrderResultURL'] = url('/sign-up/' . $order->activity->id . '/payment');
        $allpay->SendExtend['ClientRedirectURL'] = url('/sign-up/' . $order->activity->id . '/payment-info');

        if ($transation->apply_fee > 0) {
            $allpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 報名費',
                'Price' => $transation->apply_fee,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => 'localhost'
            ];
        }

        if ($transation->sponsorship_amount > 0) {
            $allpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 贊助金額',
                'Price' => $transation->sponsorship_amount,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => 'localhost'
            ];
        }

        return $allpay->CheckOutString('submit', '_self');
    }
}
