<?php

namespace App\Services;

use Mail;
use SMS;

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
    public function sendSMS(Message $message)
    {
        SMS::send(
            'email.activity-notification',
            ['content' => $message->content],
            function($sms) {
                $sms->to('+15555555555');
            }
        );
    }
}
