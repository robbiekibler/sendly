<?php

namespace NotificationChannels\Sendly;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SendlyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Sendly::class, function () {
            $key = config('services.sendly.key');

            if (empty($key)) {
                throw new \RuntimeException(
                    'Sendly API key not configured. Set SENDLY_API_KEY in your .env file.'
                );
            }

            return new Sendly($key);
        });
    }

    public function boot(): void
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sendly', function ($app) {
                return $app->make(SendlyChannel::class);
            });
        });
    }
}
