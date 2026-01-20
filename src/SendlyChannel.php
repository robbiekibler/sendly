<?php

namespace NotificationChannels\Sendly;

use Illuminate\Notifications\Notification;
use NotificationChannels\Sendly\Exceptions\CouldNotSendNotification;

class SendlyChannel
{
    public function __construct(protected Sendly $client)
    {
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): ?array
    {
        $message = $notification->toSendly($notifiable);

        if (is_string($message)) {
            $message = new SendlyMessage($message);
        }

        if (! $message instanceof SendlyMessage) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        $to = $message->to ?? $notifiable->routeNotificationFor('sendly', $notification);

        if (! $to) {
            return null;
        }

        if (empty($message->content)) {
            return null;
        }

        $options = [];
        if ($message->from) {
            $options['from'] = $message->from;
        }

        return $this->client->send($to, $message->content, $options);
    }
}
