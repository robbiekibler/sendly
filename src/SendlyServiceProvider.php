<?php

namespace NotificationChannels\Sendly;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SendlyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->app->when(SendlyChannel::class)
            ->needs(Sendly::class)
            ->give(function () {
                $config = config('services.sendly');

                if (empty($config['key'])) {
                    throw new \InvalidArgumentException(
                        'Sendly API key is not configured. Please set SENDLY_API_KEY in your .env file ' .
                        'or configure services.sendly.key in your config/services.php file.'
                    );
                }

                return new Sendly($config['key']);
            });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sendly', function ($app) {
                return $app->make(SendlyChannel::class);
            });
        });
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sendly.php', 'services.sendly');
    }
}
