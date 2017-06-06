<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 15:45
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Zones implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addZone(string $name, bool $jumpstart = false, string $organizationID = ''): \stdClass
    {
        $options = [
            'name'      => $name,
            'jumpstart' => $jumpstart
        ];

        if (!empty($organizationID)) {
            $organization = new \stdClass();
            $organization->id = $organizationID;
            $options["organization"] = $organization;
        }

        $user = $this->adapter->post('zones', [], $options);
        $body = json_decode($user->getBody());
        return $body->result;
    }
}