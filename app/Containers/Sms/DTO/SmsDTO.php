<?php

namespace App\Containers\Sms\DTO;

use App\Ship\Abstracts\DTO\DataTransferObject;

class SmsDTO extends DataTransferObject
{
    public string $phone;
    public string $message;
    public string $status;
    public string $provider;
    public ?string $provider_id;
    public string $sent_at;
}
