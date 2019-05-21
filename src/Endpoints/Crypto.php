<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Crypto implements API
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
    public function getSSLSetting($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/ssl'
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
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
    public function getSSLVerificationStatus($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/ssl/verification'
        );
        $body = json_decode($return->getBody());
        if ($body->result) {
            return $body->result;
        }
        return false;
    }

    /**
     * Get the Opportunistic Encryption feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false 
     */
    public function getOpportunisticEncryptionSetting($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_encryption'
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Get the Onion Routing feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false 
     */
    public function getOnionRoutingSetting($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_onion'
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return $body->result;
        }
        return false;
    }

    public function getHTTPSRedirectSetting($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/always_use_https'
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return $body->result->value;
        }
        return false;
    }

    public function getHTTPSRewritesSetting($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites'
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return $body->result->value;
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
    public function updateSSLSetting($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/ssl',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
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
    public function updateHTTPSRedirectSetting($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/always_use_https',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
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
    public function updateHTTPSRewritesSetting($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return true;
        }
        return false;
    }

    /**
     * Update the Oppurtunistic Encryption setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool 
     */
    public function updateOpportunisticEncryptionSetting($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_encryption',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return true;
        }
        return false;
    }

    /**
     * Update the Onion Routing setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool 
     */
    public function updateOnionRoutingSetting($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_onion',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if ($body->success) {
            return true;
        }
        return false;
    }
}
