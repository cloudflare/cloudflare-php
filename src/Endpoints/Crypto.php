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
     * Get the Opportunistic Encryption feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getOpportunisticEncryptionSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_encryption'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
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
    public function getOnionRoutingSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_onion'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result;
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
    public function updateOpportunisticEncryptionSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_encryption',
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
     * Update the Onion Routing setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateOnionRoutingSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_onion',
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
