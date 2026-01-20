<?php

namespace NotificationChannels\Sendly;

class SendlyResponse
{
    public readonly string $id;
    public readonly string $status;
    public readonly ?string $to;
    public readonly ?string $from;
    public readonly ?string $body;
    public readonly ?string $createdAt;

    protected array $rawResponse;

    public function __construct(array $response)
    {
        $this->rawResponse = $response;
        $this->id = $response['id'] ?? '';
        $this->status = $response['status'] ?? 'unknown';
        $this->to = $response['to'] ?? null;
        $this->from = $response['from'] ?? null;
        $this->body = $response['body'] ?? null;
        $this->createdAt = $response['created_at'] ?? null;
    }

    /**
     * Get the raw response array.
     */
    public function toArray(): array
    {
        return $this->rawResponse;
    }

    /**
     * Check if the message was sent successfully.
     */
    public function isSuccessful(): bool
    {
        return in_array($this->status, ['queued', 'sent', 'delivered']);
    }
}
