<?php

namespace App\Containers\Sms\Contracts;

interface SmsInterface
{
    public function send(string $phone, string $message): bool;

    public function sendToMultiple(array $phones, string $message): bool;
}
