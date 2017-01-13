<?php

/**
 * User: junade
 * Date: 13/01/2017
 * Time: 23:35
 */
class GuzzleTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {

        $auth = $this->getMockBuilder(\Cloudflare\API\Auth\Auth::class)
                     ->setMethods(['getHeaders'])
                     ->getMock();

        $client = new \Cloudflare\API\Adapter\Guzzle($auth, 'https://httpbin.org/');
        $client->get('https://httpbin.org/get');
    }
}
