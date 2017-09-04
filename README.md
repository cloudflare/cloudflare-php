# Cloudflare SDK (v4 API Binding for PHP 7)

[![Build Status](https://travis-ci.org/cloudflare/cloudflare-php.svg?branch=master)](https://travis-ci.org/cloudflare/cloudflare-php)

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

Note that this repository is currently under development, additional classes and endpoints being actively added.

## Getting Started

```php
$key     = new \Cloudflare\API\Auth\APIKey('user@example.com', 'apiKey');
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$user    = new \Cloudflare\API\Endpoints\User($adapter);
    
echo $user->getUserID();
```

## Licensing 

Licensed under the 3-clause BSD license. See the [LICENSE](LICENSE) file for details.