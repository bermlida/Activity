<?php

namespace App\Services;

use Mail;
use SMS;

use App\Models\Message;
use App\Models\User;

class MessageService
{
    /**
     * 。
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
     * 。
     *
     * @param \App\Models\User $recipient
     * @param \App\Models\Message $message
     * @return void
     */
    protected function sendMail(User $recipient, Message $message)
    {
        Mail::send(
            'email.activity-notification',
            ['content' => $message->content],
            function ($mail) use ($recipient, $message) {
                $mail->subject($message->subject);

                $mail->from(
                    'postmaster@sandbox9ebef659e197489989fb3166ad4f921c.mailgun.org',
                    $message->activity->organizer->name
                );
                    
                $mail->to($recipient->account->first()->email, $recipient->name);
            }
        );
    }

    /**
     * 。
     *
     * @param \App\Models\User $recipient
     * @param \App\Models\Message $message
     * @return void
     */
    protected function sendSMS(User $recipient, Message $message)
    {
        SMS::send(
            'email.activity-notification',
            ['content' => $message->content],
            function ($sms) use ($recipient) {
                $sms->from('');

                $sms->to($recipient->mobile_phone);
            }
        );
    }
}
