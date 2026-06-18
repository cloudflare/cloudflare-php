# Changelog

## 2.0.0

### Breaking Changes

- **Minimum PHP version raised from 7.2.5 to 8.1.** PHP 7.x and 8.0 are no
  longer supported. All of these versions are past end-of-life upstream.

### Changes

- Add support for `psr/http-message` v2.0 (constraint is now `^1.1 || ^2.0`).
  This resolves dependency conflicts with libraries that require PSR-7 v2,
  including `league/oauth2-server` and newer Drupal modules.
  ([#275](https://github.com/cloudflare/cloudflare-php/pull/275))
- Fix PHP 8.4 implicit-nullable deprecation warnings in `Guzzle::__construct()`
  and `Zones::cachePurge()`.
  ([#280](https://github.com/cloudflare/cloudflare-php/pull/280))
- Upgrade `guzzlehttp/guzzle` constraint from `^7.0.1` to `^7.4`.
- Upgrade `phpunit/phpunit` from `^5.7` to `^9.6 || ^10.0 || ^11.0`.
- Upgrade `friendsofphp/php-cs-fixer` from `^2.6` to `^3.0`.
- Remove committed `composer.lock` (correct practice for libraries).
- Update GitHub Actions workflows: `actions/checkout` v4, `actions/cache` v4,
  `php-actions/composer` v6, Semgrep runner to `ubuntu-latest`.
- Fix PHP test matrix to 8.1, 8.2, 8.3, 8.4.
- Migrate linter config from `.php_cs` to `.php-cs-fixer.php`.
- Add PHPMD ruleset file (`phpmd.xml`).
- Remove unused test variables in `DNSAnalyticsTest`.
- Update README to reflect PHP 8.1+ requirement and current project status.
