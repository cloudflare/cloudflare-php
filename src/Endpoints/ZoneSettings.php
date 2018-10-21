<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 15:45
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class ZoneSettings implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function enableTLS13($zoneID, $enable=false) {

        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => $enable ? 'on' : 'off']
        );
        $body = json_decode($return->getBody());

        return $body->result;

    }

    public function changeMinimumTLSVersion($zoneID, $minimumVersion) {

        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/min_tls_version',
            [
                'value' => $minimumVersion
            ]
        );
        $body = json_decode($return->getBody());

        return $body->result;

    }



}