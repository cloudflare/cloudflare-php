<?php
/**
 * Created by PhpStorm.
 * User: paul.adams
 * Date: 2019-02-22
 * Time: 23:28
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class ZoneSettings implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getMinifySetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/minify'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getRocketLoaderSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/rocket_loader'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getAlwaysOnlineSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/always_online'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getEmailObfuscationSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/email_obfuscation'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getServerSideExcludeSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/server_side_exclude'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getHotlinkProtectionSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/hotlink_protection'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getIPGeolocationSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/ip_geolocation'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getMirageSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/mirage'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getPolishSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/polish'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getWebPSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/webp'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getBrotliSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/brotli'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getResponseBufferingSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/response_buffering'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result;
        }

        return false;
    }

    public function getHTTP2Setting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/http2'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getHTTP3Setting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/http3'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function get0RTTSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/0rtt'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getPseudoIPv4Setting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/pseudo_ipv4'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getWebSocketSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/websockets'
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function updateMinifySetting(string $zoneID, $html, $css, $javascript)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/minify',
            [
                'value' => [
                    'html' => $html,
                    'css'  => $css,
                    'js'   => $javascript,
                ],
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function updateRocketLoaderSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/rocket_loader',
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function updateAlwaysOnlineSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/always_online',
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function updateEmailObfuscationSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/email_obfuscation',
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function updateHotlinkProtectionSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/hotlink_protection',
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function updateServerSideExcludeSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/server_side_exclude',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function updateIPGeolocationSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/ip_geolocation',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateMirageSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/mirage',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updatePolishSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/mirage',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateWebPSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/webp',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateBrotliSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/brotli',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateResponseBufferingSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/response_buffering',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateHTTP2Setting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/http2',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateHTTP3Setting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/http3',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function update0RTTSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/0rtt',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updatePseudoIPv4Setting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/pseudo_ipv4',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }

    public function updateWebSocketSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/websockets',
            [
                'value' => $value
            ]
        );
        $body = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }
}
