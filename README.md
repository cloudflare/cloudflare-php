# Cloudflare v4 API Binding for PHP 7

## Installation

The recommended way to install this package is via the Packagist Dependency Manager. 

## Cloudflare API version 4

The Cloudflare API can be found [here](https://api.cloudflare.com/).
Each API call is provided via a similarly named function within the **CloudFlare** class.

## Getting Started

```php
$key     = new \Cloudflare\API\Auth\APIKey('user@example.com', 'apiKey');
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$user    = new \Cloudflare\API\Endpoints\User($adapter);
    
echo $user->getUserID();
```

## Licensing 