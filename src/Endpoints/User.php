<?php
/**
 * User: junade
 * Date: 01/02/2017
 * Time: 12:30
 */

namespace Cloudflare\API\Endpoints;


use Cloudflare\API\Adapter\Adapter;

class User implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getUserDetails()
    {
        $user = $this->adapter->get('user', []);
        $body = json_decode($user->getBody());
        var_dump($body);
    }
}