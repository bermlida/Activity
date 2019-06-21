<?php

namespace App\Services;

use Mail;
use SMS;

use App\Models\Message;
use App\Models\User;

class MessageService
{
    /**
     * 發送電子郵件或簡訊。
     *
     * @param \App\Models\Message $message
     * @return void
     */
    public function send(Message $message)
    {
        $message->activity->users()
            ->wherePivotIn('status', $message->sending_target)
            ->get()->each(function ($user, $key) use ($message) {
                if (in_array('email', $message->sending_method)) {
                    $this->sendMail($user, $message);
                }

                if (in_array('sms', $message->sending_method)) {
                    $this->sendSMS($user, $message);
                }
            });
    }

    /**
     * 發送電子郵件。
     *
     * @param \App\Models\User $recipient
     * @param \App\Models\Message $message
     * @return void
     */
    protected function sendMail(User $recipient, Message $message)
    {
        Mail::send(
            'notification.activity-email-message',
            ['content' => $message->content],
            function ($mail) use ($recipient, $message) {
                $mail->subject($message->subject);
                
                $mail->from(
                    $message->activity->organizer->account->email, 
                    $message->activity->organizer->name
                ); //'postmaster@sandbox9ebef659e197489989fb3166ad4f921c.mailgun.org'
                    
                $mail->to($recipient->account->email, $recipient->name);
            }
        );
    }

    /**
     * 發送簡訊。
     *
     * @param \App\Models\User $recipient
     * @param \App\Models\Message $message
     * @return \SimpleSoftwareIO\SMS\OutgoingMessage
     */
    protected function sendSMS(User $recipient, Message $message)
    {
        SMS::send(
            'notification.activity-sms-message',
            ['content' => $message->content],
            function ($sms) use ($recipient) {
                $sms->from($message->activity->organizer->mobile_country_calling_code . ltrim($message->activity->organizer->mobile_phone, 0));

                $sms->to($recipient->mobile_country_calling_code . ltrim($recipient->mobile_phone, 0));
            }
        );
    }
}
