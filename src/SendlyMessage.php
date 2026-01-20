<?php

namespace NotificationChannels\Sendly;

class SendlyMessage
{
    public string $content = '';
    public ?string $from = null;
    public ?string $to = null;
    public ?string $messageType = null;

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function to(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function transactional(): self
    {
        $this->messageType = 'transactional';

        return $this;
    }
}
