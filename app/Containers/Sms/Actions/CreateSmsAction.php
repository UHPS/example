<?php

namespace App\Containers\Sms\Actions;

use App\Containers\Sms\DTO\SmsDTO;
use App\Containers\Sms\Models\Sms;
use App\Ship\Abstracts\Actions\Action;

class CreateSmsAction extends Action
{
    public function run(SmsDTO $smsDTO): Sms
    {
        $createdSms = Sms::create($smsDTO->toArray());

        return $createdSms;
    }
}
