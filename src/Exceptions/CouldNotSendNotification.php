<?php

namespace NotificationChannels\Sendly\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new self("Sendly API error: {$error}");
    }

    public static function invalidMessageObject($message): self
    {
        $type = is_object($message) ? get_class($message) : gettype($message);

        return new self("Invalid message. Expected SendlyMessage or string, got: {$type}");
    }
}
