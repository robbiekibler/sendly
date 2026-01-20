<?php

namespace NotificationChannels\Sendly;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use NotificationChannels\Sendly\Exceptions\CouldNotSendNotification;

class Sendly
{
    protected string $apiKey;
    protected HttpClient $httpClient;
    protected string $baseUrl = 'https://api.sendly.com/v1';

    public function __construct(string $apiKey, ?HttpClient $httpClient = null)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient ?? new HttpClient([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
        ]);
    }

    /**
     * Send an SMS message.
     *
     * @throws CouldNotSendNotification
     */
    public function send(string $to, string $content, array $options = []): array
    {
        $payload = array_merge(['to' => $to, 'body' => $content], $options);

        try {
            $response = $this->httpClient->request('POST', '/messages', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body['error'])) {
                throw CouldNotSendNotification::serviceRespondedWithAnError($body['error']);
            }

            return $body;
        } catch (GuzzleException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
