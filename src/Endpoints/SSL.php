<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class SSL implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get the SSL setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getSSLSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/ssl'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Get SSL Verification Info for a Zone
     *
     * @param string $zoneID The ID of the zone
     * @return array|false
     */
    public function getSSLVerificationStatus(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/ssl/verification'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body;
        }
        return false;
    }

    /**
     * Get the HTTPS Redirect setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getHTTPSRedirectSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/always_use_https'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result;
        }
        return false;
    }

    /**
     * Get the HTTPS Rewrite setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getHTTPSRewritesSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result;
        }
        return false;
    }

    /**
     * Update the SSL setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateSSLSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/ssl',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the HTTPS Redirect setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateHTTPSRedirectSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/always_use_https',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the HTTPS Rewrite setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateHTTPSRewritesSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }
}
