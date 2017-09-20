<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 16:01
 */
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

    public function testActivationTest()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "023e105f4ecef8ad9ca31a8372d0c353"
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with($this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/activation_check'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->activationCheck("c2547eb745079dac9320b638f5e225cf483cc5cfdda41");

        $this->assertTrue($result);
    }

    public function testListZones()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": [
    {
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
  ],
  "result_info": {
    "page": 1,
    "per_page": 20,
    "count": 1,
    "total_count": 2000
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('zones?page=1&per_page=20&match=all&name=example.com&status=active&order=status&direction=desc'),
                $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->listZones("example.com", "active", 1, 20, "status", "desc", "all");

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals("023e105f4ecef8ad9ca31a8372d0c353", $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
    }

    public function testGetZoneID()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": [
    {
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
  ],
  "result_info": {
    "page": 1,
    "per_page": 20,
    "count": 1,
    "total_count": 2000
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('zones?page=1&per_page=20&match=all&name=example.com'),
                $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->getZoneID("example.com");

        $this->assertEquals("023e105f4ecef8ad9ca31a8372d0c353", $result);
    }

    public function testCachePurgeEverything()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "023e105f4ecef8ad9ca31a8372d0c353"
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo([]),
                $this->equalTo(["purge_everything" => true])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurgeEverything("c2547eb745079dac9320b638f5e225cf483cc5cfdda41");

        $this->assertTrue($result);
    }
}
