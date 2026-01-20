<?php

namespace NotificationChannels\Sendly\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when the Sendly API responds with an error.
     */
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new self("Sendly API error: {$error}");
    }

    /**
     * Thrown when the message object is invalid.
     *
     * @param mixed $message
     */
    public static function invalidMessageObject($message): self
    {
        $type = is_object($message) ? get_class($message) : gettype($message);

        return new self(
            "Notification was not sent. The toSendly() method should return a SendlyMessage object or a string. " .
            "Received: {$type}"
        );
    }

    /**
     * Thrown when no recipient phone number could be determined.
     */
    public static function missingRecipient(): self
    {
        return new self(
            'Notification was not sent. No recipient phone number was provided. ' .
            'Either set a phone number on the message using ->to() or add a routeNotificationForSendly() method ' .
            'to your notifiable model.'
        );
    }

    /**
     * Thrown when the message content is empty.
     */
    public static function emptyMessage(): self
    {
        return new self('Notification was not sent. The message content is empty.');
    }

    /**
     * Thrown when API credentials are missing.
     */
    public static function missingCredentials(): self
    {
        return new self(
            'Sendly API key is not configured. Please set SENDLY_API_KEY in your .env file ' .
            'or configure services.sendly.key in your config/services.php file.'
        );
    }
}
