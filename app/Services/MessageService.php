<?php

namespace App\Services;

use Mail;

use App\Models\Message;

class MessageService
{
    /**
     * 。
     *
     * @return string
     */
    public function sendMail(Message $message)
    {
        Mail::send(
            'email.activity-notification',
            ['content' => $message->content],
            function ($mail) use ($message) {
                $mail->subject($message->subject);

                $mail->from(
                    'postmaster@sandbox9ebef659e197489989fb3166ad4f921c.mailgun.org',
                    $message->activity->organizer->name
                );
                    
                $mail->to('fir4268@gmail.com', 'bermlida');
            }
        );



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
}
