<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 16:50
 */

namespace Cloudflare\API\Configurations;

class PageRulesActions implements Configurations
{
    private $configs = array();

    public function setAlwaysOnline(bool $active)
    {
        $object = new \stdClass();
        $object->id = "always_online";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setAlwaysUseHTTPS(bool $active)
    {
        $object = new \stdClass();
        $object->id = "always_use_https";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setBrowserCacheTTL(int $ttl)
    {
        $object = new \stdClass();
        $object->id = "browser_cache_ttl";
        $object->value = $ttl;

        array_push($this->configs, $object);
    }

    public function setBrowserIntegrityCheck(bool $active)
    {
        $object = new \stdClass();
        $object->id = "browser_check";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setBypassCacheOnCookie(bool $value)
    {
        if (preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationsException("Invalid cookie string.");
        }

        $object = new \stdClass();
        $object->id = "bypass_cache_on_cookie";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setCacheByDeviceType(bool $active)
    {
        $object = new \stdClass();
        $object->id = "cache_by_device_type";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setCacheKey(string $value)
    {
        $object = new \stdClass();
        $object->id = "cache_key";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setCacheLevel(string $value)
    {
        if (!in_array($value, ["bypass", "basic", "simplified", "aggressive", "cache_everything"])) {
            throw new ConfigurationsException("Invalid cache level");
        }

        $object = new \stdClass();
        $object->id = "cache_level";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setCacheOnCookie(bool $value)
    {
        if (preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationsException("Invalid cookie string.");
        }

        $object = new \stdClass();
        $object->id = "cache_on_cookie";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setDisableApps(bool $active)
    {
        $object = new \stdClass();
        $object->id = "disable_apps";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setDisablePerformance(bool $active)
    {
        $object = new \stdClass();
        $object->id = "disable_performance";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setDisableSecurity(bool $active)
    {
        $object = new \stdClass();
        $object->id = "disable_security";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setEdgeCacheTTL(int $value)
    {
        if ($value > 2419200) {
            throw new ConfigurationsException("Edge Cache TTL too high.");
        }

        $object = new \stdClass();
        $object->id = "edge_cache_ttl";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setEmailObfuscation(bool $active)
    {
        $object = new \stdClass();
        $object->id = "disable_security";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setForwardingURL(int $statusCode, string $forwardingUrl)
    {
        if (in_array($statusCode, ['301', '302'])) {
            throw new ConfigurationsException('Status Codes can only be 301 or 302.');
        }

        $object = new \stdClass();
        $object->id = "forwarding_url";
        $object->status_code = $statusCode;
        $object->url = $forwardingUrl;

        array_push($this->configs, $object);
    }

    public function setHostHeaderOverride(bool $active)
    {
        $object = new \stdClass();
        $object->id = "host_header_override";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setHotlinkProtection(bool $active)
    {
        $object = new \stdClass();
        $object->id = "hotlink_protection";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setIPGeoLocationHeader(bool $active)
    {
        $object = new \stdClass();
        $object->id = "ip_geolocation";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setMinification(bool $html, bool $css, bool $js)
    {
        $object = new \stdClass();
        $object->id = "minification";
        $object->html = $html === true ? "on" : "off";
        $object->css = $css === true ? "on" : "off";
        $object->js = $js === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setMirage(bool $active)
    {
        $object = new \stdClass();
        $object->id = "mirage";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setOriginErrorPagePassthru(bool $active)
    {
        $object = new \stdClass();
        $object->id = "origin_error_page_pass_thru";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setQueryStringSort(bool $active)
    {
        $object = new \stdClass();
        $object->id = "sort_query_string_for_cache";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setDisableRailgun(bool $active)
    {
        $object = new \stdClass();
        $object->id = "disable_railgun";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setResolveOverride(bool $value)
    {
        $object = new \stdClass();
        $object->id = "resolve_override";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setRespectStrongEtag(bool $active)
    {
        $object = new \stdClass();
        $object->id = "respect_strong_etag";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setResponseBuffering(bool $active)
    {
        $object = new \stdClass();
        $object->id = "response_buffering";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setRocketLoader(string $value)
    {
        if (!in_array($value, ["off", "manual", "automatic"])) {
            throw new ConfigurationsException('Rocket Loader can only be off, automatic, or manual.');
        }

        $object = new \stdClass();
        $object->id = "rocket_loader";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setSecurityLevel(string $value)
    {
        if (!in_array($value, ["off", "essentially_off", "low", "medium", "high", "under_attack"])) {
            throw new ConfigurationsException('Can only be set to off, essentially_off, low, medium, high or under_attack.');
        }

        $object = new \stdClass();
        $object->id = "security_level";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setServerSideExcludes(bool $active)
    {
        $object = new \stdClass();
        $object->id = "server_side_exclude";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setSmartErrors(bool $active)
    {
        $object = new \stdClass();
        $object->id = "smart_errors";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setSSL(string $value)
    {
        if (!in_array($value, ["off", "flexible", "full", "strict", "origin_pull"])) {
            throw new ConfigurationsException('Can only be set to off, flexible, full, strict, origin_pull.');
        }

        $object = new \stdClass();
        $object->id = "smart_errors";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function setTrueClientIpHeader(bool $active)
    {
        $object = new \stdClass();
        $object->id = "true_client_ip_header";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setWAF(bool $active)
    {
        $object = new \stdClass();
        $object->id = "waf";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setAutomatedHTTPSRewrites(bool $active)
    {
        $object = new \stdClass();
        $object->id = "automatic_https_rewrites";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function setOpportunisticEncryption(bool $active)
    {
        $object = new \stdClass();
        $object->id = "opportunistic_encryption";
        $object->value = $active === true ? "on" : "off";

        array_push($this->configs, $object);
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
