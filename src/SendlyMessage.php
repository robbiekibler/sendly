<?php

namespace NotificationChannels\Sendly;

class SendlyMessage
{
    protected string $content = '';
    protected ?string $from = null;
    protected ?string $to = null;
    protected array $metadata = [];

    /**
     * Create a new SendlyMessage instance.
     *
     * @param string $content The message content
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Create a new message instance.
     *
     * @param string $content The message content
     */
    public static function create(string $content = ''): self
    {
        return new self($content);
    }

    /**
     * Set the message content.
     *
     * @param string $content The message content
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sender phone number.
     *
     * @param string $from The sender phone number in E.164 format
     */
    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the recipient phone number.
     *
     * @param string $to The recipient phone number in E.164 format
     */
    public function to(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Add metadata to the message.
     *
     * @param array $metadata Key-value pairs of metadata
     */
    public function metadata(array $metadata): self
    {
        $this->metadata = array_merge($this->metadata, $metadata);

        return $this;
    }

    /**
     * Get the message content.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get the sender phone number.
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Get the recipient phone number.
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * Get the message metadata.
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Get the message as an array for the API.
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->from) {
            $data['from'] = $this->from;
        }

        if (! empty($this->metadata)) {
            $data['metadata'] = $this->metadata;
        }

        return $data;
    }
}
