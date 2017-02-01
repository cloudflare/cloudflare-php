<?php

/**
 * User: junade
 * Date: 01/02/2017
 * Time: 12:50
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    public function testGetUserDetails()
    {
        $key     = new \Cloudflare\API\Auth\APIKey('mjsa@junade.com', '2e2f2eb5934b328b9a7c190ce4c9d887875b1');
        $adapter = new Cloudflare\API\Adapter\Guzzle($key);
        $user    = new \Cloudflare\API\Endpoints\User($adapter);

        $user->getUserDetails();
    }
}
