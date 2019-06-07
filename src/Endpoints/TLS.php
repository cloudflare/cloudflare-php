<?php
/**
 * Created by PhpStorm.
 * User: Jurgen Coetsiers
 * Date: 21/10/2018
 * Time: 09:10
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class TLS implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get the TLS Client Auth setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getTLSClientAuth($zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/tls_client_auth'
        );
        $body   = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Enable TLS 1.3 for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return bool
     */
    public function enableTLS13($zoneID)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'on']
        );
        $body   = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Disable TLS 1.3 for the zone
     *
     * @param string $zoneID The ID of the zone
     * @return bool
     */
    public function disableTLS13($zoneID)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'off']
        );
        $body   = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the minimum TLS version setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $minimumVersion The version to update to
     * @return bool
     */
    public function changeMinimumTLSVersion($zoneID, $minimumVersion)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/min_tls_version',
            [
                'value' => $minimumVersion,
            ]
        );
        $body   = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the TLS Client Auth setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateTLSClientAuth($zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_client_auth',
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }
}
