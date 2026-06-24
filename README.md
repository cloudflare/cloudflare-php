# Cloudflare SDK (v4 API Binding for PHP)

> **Note:** This is a community-maintained PHP SDK covering a subset of the
> Cloudflare API. A comprehensive, auto-generated PHP SDK is planned for the
> future. In the meantime, for full API coverage consider using the
> [Cloudflare API](https://developers.cloudflare.com/api/) directly.

## Requirements

- PHP 8.1 or later

## Installation

Install via Composer ([cloudflare/sdk](https://packagist.org/packages/cloudflare/sdk)):

```
composer require cloudflare/sdk
```

## Cloudflare API version 4

The Cloudflare API can be found [here](https://developers.cloudflare.com/api/).
Each API call is provided via a similarly named function within various classes in the **Cloudflare\API\Endpoints** namespace:

- [x] [DNS Records](https://www.cloudflare.com/dns/)
- [x] DNS Analytics
- [x] Zones
- [x] User Administration (partial)
- [x] [Cloudflare IPs](https://www.cloudflare.com/ips/)
- [x] Page Rules
- [x] [Web Application Firewall (WAF)](https://www.cloudflare.com/waf/)
- [ ] Virtual DNS Management
- [x] Custom hostnames
- [x] Manage TLS settings
- [x] Zone Lockdown and User-Agent Block rules
- [ ] Organization Administration
- [x] [Railgun](https://www.cloudflare.com/railgun/) administration
- [ ] [Keyless SSL](https://blog.cloudflare.com/keyless-ssl-the-nitty-gritty-technical-details/)
- [x] [Origin CA](https://blog.cloudflare.com/universal-ssl-encryption-all-the-way-to-the-origin-for-free/)
- [x] Crypto
- [x] Load Balancers
- [x] Firewall Settings
- [x] [Images](https://www.cloudflare.com/products/cloudflare-images/)

## Getting Started

```php
$key     = new Cloudflare\API\Auth\APIKey('user@example.com', 'apiKey');
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$user    = new Cloudflare\API\Endpoints\User($adapter);

echo $user->getUserID();
```

## Getting started with images

```php
$key     = new Cloudflare\API\Auth\APIToken('apiToken');
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$images    = new Cloudflare\API\Endpoints\Images($adapter);

var_dump($images->listImages('accountId'));
```

## Contributions

We welcome community contribution to this repository. [CONTRIBUTING.md](CONTRIBUTING.md) will help you start contributing.

## Licensing

Licensed under the 3-clause BSD license. See the [LICENSE](LICENSE) file for details.
