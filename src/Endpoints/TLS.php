<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 15:45
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

    public function enableTLS13($zoneID, $enable=false)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => $enable ? 'on' : 'off']
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

        return $body->result;
    }
}
