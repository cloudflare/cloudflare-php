<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class ZoneSubscriptions implements API
{
    use BodyAccessorTrait;

    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addZoneSubscription(string $zoneId, string $ratePlanId = ''): stdClass
    {
        $options = [];

        if (empty($ratePlanId) === false) {
            $options['rate_plan'] = [
                'id' => $ratePlanId,
            ];
        }

        $account    = $this->adapter->post('zones/' . $zoneId . '/subscription', $options);
        $this->body = json_decode($account->getBody());

        return $this->body->result;
    }
}
