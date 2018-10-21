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

    public function enableTLS13($zoneID)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'on']
        );
        $body = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }

    public function disableTLS13($zoneID)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'off']
        );
        $body = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }



    public function changeMinimumTLSVersion($zoneID, $minimumVersion)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/min_tls_version',
            [
                'value' => $minimumVersion
            ]
        );
        $body = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }
}
