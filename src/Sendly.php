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
     * Get the messages API interface.
     */
    public function messages(): SendlyMessages
    {
        return new SendlyMessages($this);
    }

    /**
     * Send an HTTP request to the Sendly API.
     *
     * @throws CouldNotSendNotification
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        try {
            $response = $this->httpClient->request($method, $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $data,
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

    /**
     * Get the API key.
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
