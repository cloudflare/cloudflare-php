<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 16:01
 */
class ZonesTest extends TestCase
{
    public function testAddZone()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addZone.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones'),
                $this->equalTo([]),
                $this->equalTo(['name' => 'example.com', 'jumpstart' => false])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->addZone("example.com");

        $this->assertObjectHasAttribute("id", $result);
        $this->assertEquals("023e105f4ecef8ad9ca31a8372d0c353", $result->id);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createPageRule.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $org = new stdClass();
        $org->id = "01a7362d577a6c3019a474fd6f485823";

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones'),
                $this->equalTo([]),
                $this->equalTo(['name' => 'example.com', 'jumpstart' => true, 'organization' => $org])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $zones->addZone("example.com", true, "01a7362d577a6c3019a474fd6f485823");
    }

    public function testActivationTest()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/activationTest.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/activation_check'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->activationCheck("c2547eb745079dac9320b638f5e225cf483cc5cfdda41");

        $this->assertTrue($result);
    }

    public function testListZones()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listZones.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20,
                'match' => 'all',
                'name' => 'example.com',
                'status' => 'active',
                'order' => 'status',
                'direction' => 'desc'
              ]),
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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getZoneId.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20,
                'match' => 'all',
                'name' => 'example.com',
                ]),
              $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->getZoneID("example.com");

        $this->assertEquals("023e105f4ecef8ad9ca31a8372d0c353", $result);
    }

    public function testCachePurgeEverything()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeEverything.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo([]),
                $this->equalTo(["purge_everything" => true])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurgeEverything("c2547eb745079dac9320b638f5e225cf483cc5cfdda41");

        $this->assertTrue($result);
    }
}
