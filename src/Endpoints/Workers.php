<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 16/01/2023
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Workers implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $zoneID
     * @return mixed
     */
    public function listRoutes(string $zoneID)
    {
        $loadBalancers = $this->adapter->get('zones/' . $zoneID . '/workers/routes');
        $this->body = json_decode($loadBalancers->getBody());

        return $this->body->result;
    }
}
