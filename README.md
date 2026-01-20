# Sendly SMS Notification Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/sendly.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/sendly)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send SMS notifications using [Sendly](https://sendly.com) with Laravel 10.x and 11.x.

## Installation

```bash
composer require laravel-notification-channels/sendly
```

## Configuration

Add your Sendly API key to `config/services.php`:

```php
'sendly' => [
    'key' => env('SENDLY_API_KEY'),
],
```

## Usage

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Sendly\SendlyChannel;
use NotificationChannels\Sendly\SendlyMessage;

class OrderShipped extends Notification
{
    public function via($notifiable): array
    {
        return [SendlyChannel::class];
    }

    public function toSendly($notifiable): SendlyMessage
    {
        return (new SendlyMessage('Your order has been shipped!'))
            ->from('+15551234567');
    }
}
```

Add a `routeNotificationForSendly` method to your notifiable model:

```php
public function routeNotificationForSendly(): string
{
    return $this->phone_number;
}
```

### Available methods

| Method | Description |
|--------|-------------|
| `content(string)` | Set the message body |
| `from(string)` | Set the sender phone number |
| `to(string)` | Set the recipient (overrides routeNotificationForSendly) |

### Simple string messages

```php
public function toSendly($notifiable): string
{
    return 'Your order has been shipped!';
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
