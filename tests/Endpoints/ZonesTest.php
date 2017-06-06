<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 16:01
 */

use Cloudflare\API\Endpoints\Zones;

class ZonesTest extends PHPUnit_Framework_TestCase
{
    public function testAddZone()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "023e105f4ecef8ad9ca31a8372d0c353",
    "name": "example.com",
    "development_mode": 7200,
    "original_name_servers": [
      "ns1.originaldnshost.com",
      "ns2.originaldnshost.com"
    ],
    "original_registrar": "GoDaddy",
    "original_dnshost": "NameCheap",
    "created_on": "2014-01-01T05:20:00.12345Z",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "name_servers": [
      "tony.ns.cloudflare.com",
      "woz.ns.cloudflare.com"
    ],
    "owner": {
      "id": "7c5dae5552338874e5053f2534d2767a",
      "email": "user@example.com",
      "owner_type": "user"
    },
    "permissions": [
      "#zone:read",
      "#zone:edit"
    ],
    "plan": {
      "id": "e592fd9519420ba7405e1307bff33214",
      "name": "Pro Plan",
      "price": 20,
      "currency": "USD",
      "frequency": "monthly",
      "legacy_id": "pro",
      "is_subscribed": true,
      "can_subscribe": true
    },
    "plan_pending": {
      "id": "e592fd9519420ba7405e1307bff33214",
      "name": "Pro Plan",
      "price": 20,
      "currency": "USD",
      "frequency": "monthly",
      "legacy_id": "pro",
      "is_subscribed": true,
      "can_subscribe": true
    },
    "status": "active",
    "paused": false,
    "type": "full"
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with($this->equalTo('zones'),
                $this->equalTo([]),
                $this->equalTo(['name' => 'example.com', 'jumpstart' => false])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->addZone("example.com");

        $this->assertObjectHasAttribute("id", $result);
        $this->assertEquals("023e105f4ecef8ad9ca31a8372d0c353", $result->id);

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $org = new stdClass();
        $org->id = "01a7362d577a6c3019a474fd6f485823";

        $mock->expects($this->once())
            ->method('post')
            ->with($this->equalTo('zones'),
                $this->equalTo([]),
                $this->equalTo(['name' => 'example.com', 'jumpstart' => true, 'organization' => $org])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $zones->addZone("example.com", true, "01a7362d577a6c3019a474fd6f485823");
    }
}
