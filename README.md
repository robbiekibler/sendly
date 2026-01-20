# Sendly SMS Notification Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/sendly.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/sendly)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/actions/workflow/status/laravel-notification-channels/sendly/tests.yml?branch=main&style=flat-square)](https://github.com/laravel-notification-channels/sendly/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/sendly.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/sendly)

This package makes it easy to send SMS notifications using [Sendly](https://sendly.com) with Laravel 10.x and 11.x.

## Contents

- [Installation](#installation)
- [Setting up the Sendly service](#setting-up-the-sendly-service)
- [Usage](#usage)
  - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

```bash
composer require laravel-notification-channels/sendly
```

## Setting up the Sendly service

Add your Sendly API key to your `.env` file:

```env
SENDLY_API_KEY=sk_live_v1_your_api_key
SENDLY_FROM_NUMBER=+15551234567
```

Then add the configuration to your `config/services.php` file:

```php
'sendly' => [
    'key' => env('SENDLY_API_KEY'),
    'from' => env('SENDLY_FROM_NUMBER'),
],
```

## Usage

You can use the Sendly channel in your notification classes:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Sendly\SendlyChannel;
use NotificationChannels\Sendly\SendlyMessage;

class OrderShipped extends Notification
{
    public function via($notifiable): array
    {
        return ['sendly'];
    }

    public function toSendly($notifiable): SendlyMessage
    {
        return (new SendlyMessage())
            ->content('Your order has been shipped!')
            ->from('+15551234567');
    }
}
```

### Using a string message

For simple messages, you can return a string directly:

```php
public function toSendly($notifiable): string
{
    return 'Your order has been shipped!';
}
```

### Setting the recipient

The package will automatically look for the recipient phone number in the following order:

1. The `to()` method on the message
2. `routeNotificationForSendly()` method on the notifiable
3. `routeNotificationForSms()` method on the notifiable
4. `phone_number` property on the notifiable
5. `phone` property on the notifiable

You can customize this by adding a `routeNotificationForSendly` method to your notifiable model:

```php
public function routeNotificationForSendly(): string
{
    return $this->phone_number;
}
```

Or set the recipient directly on the message:

```php
public function toSendly($notifiable): SendlyMessage
{
    return (new SendlyMessage())
        ->to('+15559876543')
        ->content('Hello!');
}
```

### Available Message methods

| Method | Description |
|--------|-------------|
| `content(string $content)` | Set the message body |
| `from(string $from)` | Set the sender phone number (E.164 format) |
| `to(string $to)` | Set the recipient phone number (E.164 format) |
| `metadata(array $metadata)` | Add custom metadata to the message |

### Using the Sendly client directly

You can also use the Sendly client directly for more control:

```php
use NotificationChannels\Sendly\Sendly;

$client = new Sendly('sk_live_v1_your_api_key');

$message = $client->messages()->send(
    '+15551234567',
    'Hello from Sendly!'
);

echo "Sent: " . $message->id;
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email security@example.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Laravel Notification Channels](https://github.com/laravel-notification-channels)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
