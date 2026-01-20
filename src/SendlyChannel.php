<?php

namespace NotificationChannels\Sendly;

use Illuminate\Notifications\Notification;
use NotificationChannels\Sendly\Exceptions\CouldNotSendNotification;

class SendlyChannel
{
    protected Sendly $client;

    public function __construct(Sendly $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return SendlyResponse|null
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): ?SendlyResponse
    {
        $message = $notification->toSendly($notifiable);

        if (is_string($message)) {
            $message = new SendlyMessage($message);
        }

        if (! $message instanceof SendlyMessage) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        $to = $message->getTo() ?? $this->getRecipient($notifiable);

        if (! $to) {
            throw CouldNotSendNotification::missingRecipient();
        }

        $content = $message->getContent();

        if (empty($content)) {
            throw CouldNotSendNotification::emptyMessage();
        }

        return $this->client->messages()->send(
            $to,
            $content,
            $message->toArray()
        );
    }

    /**
     * Get the recipient phone number from the notifiable.
     *
     * @param mixed $notifiable
     */
    protected function getRecipient($notifiable): ?string
    {
        if ($notifiable->routeNotificationFor('sendly')) {
            return $notifiable->routeNotificationFor('sendly');
        }

        if ($notifiable->routeNotificationFor('sms')) {
            return $notifiable->routeNotificationFor('sms');
        }

        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }

        if (isset($notifiable->phone)) {
            return $notifiable->phone;
        }

        return null;
    }
}
