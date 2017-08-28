<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;

class AllpayService
{
    /**
     * 。
     *
     * @return string
     */
    public function getCheckOut($order, Transaction $transation)
    {
        $allpay = app('allpay')->instance();

        $allpay->Send['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $allpay->Send['TotalAmount'] = $transation->apply_fee + $transation->sponsorship_amount;
        $allpay->Send['TradeDesc'] = $order->activity->name;
        $allpay->Send['ChoosePayment'] = \PaymentMethod::ALL;

        $allpay->Send['ReturnURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $allpay->Send['OrderResultURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $allpay->SendExtend['ClientRedirectURL'] = route('sign-up::payment::deal-info', [$order->activity]);

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

        return $allpay->CheckOutString(null);
    }

    /**
     * 。
     *
     * @return string
     */
    public function getCheckOutForm($order, Transaction $transation)
    {
        $allpay = app('allpay')->instance();
        $allpay->Send['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $allpay->Send['TotalAmount'] = $transation->apply_fee + $transation->sponsorship_amount;
        $allpay->Send['TradeDesc'] = $order->activity->name;
        $allpay->Send['ChoosePayment'] = \PaymentMethod::ALL;

        $allpay->Send['ReturnURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $allpay->Send['OrderResultURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $allpay->SendExtend['ClientRedirectURL'] = route('sign-up::payment::deal-info', [$order->activity]);

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

    /**
     * 。
     *
     * @return void
     */
    public function queryTradeInfo(Transaction $transaction)
    {
        $allpay = app('allpay')->instance();

        $allpay->ServiceURL = 'https://payment-stage.allpay.com.tw/Cashier/QueryTradeInfo/V4';
        $allpay->Query['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Query['TradeNo'] = $transation->payment_result->TradeNo;
        $allpay->Query['TimeStamp'] = strtotime(date('Y-m-d H:i:s'));

        return $allpay->QueryTradeInfo();
    }

    /**
     * 。
     *
     * @return void
     */
    public function cancelCreditTrade(Transaction $transaction)
    {
        $today = Carbon::today()->setTime(23, 59, 59);
        $payment_date = Carbon::parse('Y-m-d H:i:s', $transaction->payment_result->PaymentDate);

        $allpay = app('allpay')->instance();

        $allpay->ServiceURL = 'https://payment.allpay.com.tw/CreditDetail/DoAction';
        $allpay->Query['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Query['TradeNo'] = $transation->payment_result->TradeNo;
        $allpay->Query['Action'] = $today->gt($payment_date) ? 'R' : 'N';
        $allpay->Query['TotalAmount'] = $transation->payment_result->PayAmt;

        return $allpay->DoAction();
    }
}
