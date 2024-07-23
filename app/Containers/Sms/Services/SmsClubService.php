<?php

namespace App\Containers\Sms\Services;

use Illuminate\Support\Facades\Http;
use App\Containers\Sms\Contracts\SmsInterface;

class SmsClubService implements SmsInterface
{
    protected $client;

    public function __construct($key, $url)
    {
        $this->client = Http::asJson()
            ->withToken($key)
            ->baseUrl($url);
    }

    public function send(string $phone, string $message): bool
    {
        $params = [
            'src_addr' => config('sms.sms-club.from'),
            'phone'    => [$phone],
            'message'  => $message,
        ];

        $response = $this->client->post('sms/send', $params);

        return isset( json_decode($response->body())->success_request) && $response->status() === 200;
    }

    public function sendToMultiple(array $phones, string $message): bool
    {
        $params = [
            'src_addr' => config('sms.sms-club.from'),
            'phone'    => $phones,
            'message'  => $message,
        ];

        $response = $this->client->post('message/sms', $params);

        return isset( json_decode($response->body())->success_request);
    }
}
