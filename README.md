# Cloudflare v4 API Binding for PHP 7

## Installation

The recommended way to install this package is via the Packagist Dependency Manager. 

## Cloudflare API version 4

The Cloudflare API can be found [here](https://api.cloudflare.com/).
Each API call is provided via a similarly named function within various classes in the **Cloudflare\API\Endpoints** namespace:


- [x] DNS Records
- [x] Zones
- [x] User Administration (partial)
- [ ] Cloudflare IPs
- [ ] Page Rules
- [ ] Web Application Firewall (WAF)
- [ ] Virtual DNS Management
- [ ] Custom hostnames
- [ ] Organization Administration
- [ ] [Railgun](https://www.cloudflare.com/railgun/) administration
- [ ] [Keyless SSL](https://blog.cloudflare.com/keyless-ssl-the-nitty-gritty-technical-details/)
- [ ] [Origin CA](https://blog.cloudflare.com/universal-ssl-encryption-all-the-way-to-the-origin-for-free/)

## Getting Started

```php
$key     = new \Cloudflare\API\Auth\APIKey('user@example.com', 'apiKey');
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$user    = new \Cloudflare\API\Endpoints\User($adapter);
    
echo $user->getUserID();
```

## Licensing 