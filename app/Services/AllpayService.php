<?php

namespace App\Services;

use Ecpay;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Transaction;

class AllpayService
{
    /**
     * 將所需資料透過表單遞交給第三方金流廠商。
     *
     * @return string
     */
    public function getCheckOut($order, Transaction $transation)
    {
        $ecpay = app('ecpay')->instance();

        $ecpay->Send['MerchantTradeNo'] = $transation->serial_number;
        $ecpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $ecpay->Send['TotalAmount'] = $transation->apply_fee + $transation->sponsorship_amount;
        $ecpay->Send['TradeDesc'] = $order->activity->name;
        $ecpay->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL;

        $ecpay->Send['ReturnURL'] = route('sign-up::payment::deal-result-delay', [$order->activity]);
        $ecpay->Send['OrderResultURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $ecpay->SendExtend['ClientRedirectURL'] = route('sign-up::payment::deal-info', [$order->activity]);

        if ($transation->apply_fee > 0) {
            $ecpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 報名費',
                'Price' => $transation->apply_fee,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => route('visit::activity', [$order->activity])
            ];
        }

        if ($transation->sponsorship_amount > 0) {
            $ecpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 贊助金額',
                'Price' => $transation->sponsorship_amount,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => route('visit::activity', [$order->activity])
            ];
        }
        
        return $ecpay->CheckOutString(null);
    }

    /**
     * 顯示將所需資料遞交給第三方金流廠商的表單。
     *
     * @return string
     */
    public function getCheckOutForm($order, Transaction $transation)
    {
        $ecpay = app('ecpay')->instance();
        $ecpay->Send['MerchantTradeNo'] = $transation->serial_number;
        $ecpay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
        $ecpay->Send['TotalAmount'] = $transation->apply_fee + $transation->sponsorship_amount;
        $ecpay->Send['TradeDesc'] = $order->activity->name;
        $ecpay->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL;

        $ecpay->Send['ReturnURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $ecpay->Send['OrderResultURL'] = route('sign-up::payment::deal-result', [$order->activity]);
        $ecpay->SendExtend['ClientRedirectURL'] = route('sign-up::payment::deal-info', [$order->activity]);

        if ($transation->apply_fee > 0) {
            $ecpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 報名費',
                'Price' => $transation->apply_fee,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => route('visit::activity', [$order->activity])
            ];
        }

        if ($transation->sponsorship_amount > 0) {
            $ecpay->Send['Items'][] = [
                'Name' => $order->activity->name . ' 贊助金額',
                'Price' => $transation->sponsorship_amount,
                'Currency' => '元',
                'Quantity' => 1,
                'URL' => route('visit::activity', [$order->activity])
            ];
        }

        return $ecpay->CheckOutString('submit', '_self');
    }

    /**
     * 透過第三方金流廠商查詢金流交易資料。
     *
     * @return array
     */
    public function queryTradeInfo(Transaction $transaction)
    {
        $ecpay = app('ecpay')->instance();

        $ecpay->ServiceURL = 'https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5';
        $ecpay->Query['MerchantTradeNo'] = $transation->serial_number;
        $ecpay->Query['TradeNo'] = $transation->payment_result->TradeNo;
        $ecpay->Query['TimeStamp'] = strtotime(date('Y-m-d H:i:s'));

        return $ecpay->QueryTradeInfo();
    }

    /**
     * 透過第三方金流廠商取消信用卡交易。
     *
     * @return array
     */
    public function cancelCreditTrade(Transaction $transaction)
    {
        $today = Carbon::today()->setTime(23, 59, 59);
        $payment_date = Carbon::parse('Y/m/d H:i:s', $transaction->payment_result->PaymentDate);

        $allpay = app('allpay')->instance();

        $allpay->ServiceURL = 'https://payment.allpay.com.tw/CreditDetail/DoAction';
        $allpay->Query['MerchantTradeNo'] = $transation->serial_number;
        $allpay->Query['TradeNo'] = $transation->payment_result->TradeNo;
        $allpay->Query['Action'] = $today->gt($payment_date) ? 'R' : 'N';
        $allpay->Query['TotalAmount'] = $transation->payment_result->PayAmt;

        return $allpay->DoAction();
    }
}
