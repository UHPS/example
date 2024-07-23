<?php

namespace App\Containers\Sms\Services;

use Illuminate\Support\Facades\Http;
use App\Containers\Sms\Contracts\SmsInterface;

class EsputnikService implements SmsInterface
{
    protected $client;

    public function __construct($user, $key, $url)
    {
        $this->client = Http::asJson()
            ->withBasicAuth($user, $key)
            ->baseUrl($url);
    }

    public function send(string $phone, string $message): bool
    {
        $params = [
            'from'         => config('sms.esputnik.from'),
            'phoneNumbers' => [$phone],
            'text'         => $message,
        ];

        $response = $this->client->post('message/sms', $params);

        return $response->ok();
    }

    public function sendToMultiple(array $phones, string $message): bool
    {
        $params = [
            'from'         => config('sms.esputnik.from'),
            'phoneNumbers' => $phones,
            'text'         => $message,
        ];

        $response = $this->client->post('message/sms', $params);

        return $response->ok();
    }
}
