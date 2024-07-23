<?php

namespace App\Containers\Sms\Services;

use App\Containers\Sms\DTO\SmsDTO;
use App\Containers\Sms\Enums\SmsStatusEnum;
use App\Containers\Sms\Contracts\SmsInterface;
use App\Containers\Sms\Actions\CreateSmsAction;

class SmsDecorator implements SmsInterface
{
    protected array $drivers = [];
    private CreateSmsAction $createSmsAction;

    public function __construct(SmsInterface ...$smsDrivers)
    {
        $this->drivers = $smsDrivers;
        $this->createSmsAction = app(CreateSmsAction::class);
    }

    public function send(string $phone, string $message): bool
    {
        return $this->trySendSms($phone, $message);
    }

    public function sendToMultiple(array $phones, string $message): bool
    {
        return $this->tryToMultipleSms($phones, $message);
    }

    private function trySendSms(string $phone, string $message): bool
    {
        $sent = false;
        $usedProvider = 'All Drivers';

        foreach ($this->drivers as $driver) {
            if ($driver->send($phone, $message)) {
                $sent = true;
                $usedProvider = get_class($driver);
                break;
            }
        }

        $status = $sent ? SmsStatusEnum::SENT : SmsStatusEnum::FAILED;

        $this->createLogSms($phone, $message, $usedProvider, $status);

        return $sent;
    }

    private function tryToMultipleSms(array $phones, string $message): bool
    {
        $sent = false;
        $usedProvider = 'All Drivers';

        foreach ($this->drivers as $driver) {
            if ($driver->sendToMultiple($phones, $message)) {
                $sent = true;
                $usedProvider = get_class($driver);
                break;
            }
        }

        $status = $sent ? SmsStatusEnum::SENT : SmsStatusEnum::FAILED;
        foreach ($phones as $phone) {
            $this->createLogSms($phone, $message, $usedProvider, $status);
        }

        return $sent;
    }


    private function createLogSms(string $phone, string $message, string $provider, SmsStatusEnum $status): void
    {
        $smsDTO = SmsDTO::from([
            'phone'    => $phone,
            'message'  => $message,
            'status'   => $status->value,
            'provider' => $provider,
            'sent_at'  => now(),
        ]);

        $this->createSmsAction->run($smsDTO);
    }
}
