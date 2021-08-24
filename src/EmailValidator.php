<?php

namespace Masnathan\EmailValidator;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

final class EmailValidator
{
    private string $host;
    private string $key;
    private Client $client;

    public function __construct(string $host, string $key, Client $client = null)
    {
        $this->host = $host;
        $this->key = $key;
        $this->client = $client ?? new Client();
    }

    private function post(string $section, array $params): ResponseInterface
    {
        return $this->client->post(sprintf("https://%s/api/%s", $this->host, $section), [
            'timeout' => 30,
            'form_params' => $params,
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);
    }

    private function get(string $section): ResponseInterface
    {
        return $this->client->get(sprintf("https://%s/api/%s", $this->host, $section), [
            'timeout' => 30,
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);
    }

    public function check(string $email): array
    {
        $response = $this->post('v2.0/email', compact('email'));

        return json_decode($response->getBody()->getContents(), true);
    }

    public function checkBatch(array $batch, string $webhook = null): array
    {
        $payload = [
            'email' => implode(',', $batch),
        ];

        if ($webhook) {
            $payload['webhook'] = $webhook;
        }

        $response = $this->post('v2.0/email/batch', $payload);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function report(string $reportId): array
    {
        $response = $this->get('v2.0/report/' . $reportId);

        return json_decode($response->getBody()->getContents(), true);
    }
}
