<?php

namespace NotificationChannels\Sendly;

use NotificationChannels\Sendly\Exceptions\CouldNotSendNotification;

class SendlyMessages
{
    protected Sendly $client;

    public function __construct(Sendly $client)
    {
        $this->client = $client;
    }

    /**
     * Send an SMS message.
     *
     * @param string $to The recipient phone number in E.164 format
     * @param string $content The message content
     * @param array $options Additional options (from, metadata, etc.)
     * @return SendlyResponse
     *
     * @throws CouldNotSendNotification
     */
    public function send(string $to, string $content, array $options = []): SendlyResponse
    {
        $payload = array_merge([
            'to' => $to,
            'body' => $content,
        ], $options);

        $response = $this->client->request('POST', '/messages', $payload);

        return new SendlyResponse($response);
    }
}
