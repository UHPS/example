<?php

namespace App\Containers\Sms\Channels;

use Illuminate\Notifications\Notification;
use App\Containers\Sms\Contracts\SmsInterface;

class SmsChannel
{
    public function __construct(
        private SmsInterface $smsService
    ) {}

    public function send($notifiable, Notification $notification)
    {
        $message = optional($notification)->toSms($notifiable);

        $phone = optional($notification)->phone;

        $this->smsService->send($phone, $message);
    }
}
