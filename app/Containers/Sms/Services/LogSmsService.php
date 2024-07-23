<?php

namespace App\Containers\Sms\Services;

use Illuminate\Support\Facades\Log;
use App\Containers\Sms\Contracts\SmsInterface;

class LogSmsService implements SmsInterface
{
    public function send(string $phone, string $message): bool
    {
        Log::info('SMS sent to ' . $phone . ' with message: ' . $message);

        return true;
    }

    public function sendToMultiple(array $phones, string $message): bool
    {
        Log::info('SMS sent to ' . implode(', ', $phones) . ' with message: ' . $message);

        return true;
    }
}
