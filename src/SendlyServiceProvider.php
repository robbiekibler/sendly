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
            return new Sendly(config('services.sendly.key'));
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
