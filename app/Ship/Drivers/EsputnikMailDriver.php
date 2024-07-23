<?php

namespace App\Ship\Drivers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;

class EsputnikMailDriver implements TransportInterface
{
    protected $client;

    public function __construct($user, $key, $url)
    {
        $this->client = Http::asJson()
            ->withBasicAuth($user, $key)
            ->baseUrl($url);
    }

    public function __toString(): string
    {
        return 'esputnik';
    }

    public function send(RawMessage $message, Envelope $envelope = null): ?SentMessage
    {
        $headers = optional($message)->getHeaders();

        $emails = collect($headers->get('To')->getAddresses())->map(function ($email) {
            return $email->getAddress();
        })->toArray();

        $params = [
            'from'     => 'vacancies@pidbir.com.ua',
            'name'     => $headers->get('From')->getName(),
            'subject'  => $headers->get('Subject')->getValue(),
            'htmlText' => optional($message)->getHtmlBody(),
            'emails'   => $emails,
        ];

        $response = $this->client->post('message/email', $params);

        if (!$response->ok()) {
            Log::error('EsputnikMailDriver error', [
                'response' => $response->json() ?? $response->body(),
                'params'   => $params,
            ]);
        }

        return $response->ok() ? new SentMessage($message, $envelope) : null;
    }
}
