<?php

namespace Cloudflare\API\Test\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Zones;
use Cloudflare\API\Test\TestCase;

class ZoneDeleteTest extends TestCase
{
    public function testDeleteTest()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteZoneTest.json');
        $mock = $this->createMock(Adapter::class);
        $mock->method('delete')->willReturn($response);
        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353')
            );
        $zones = new Zones($mock);
        $result = $zones->deleteZone('023e105f4ecef8ad9ca31a8372d0c353');
        $this->assertTrue($result);
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $zones->getBody()->result->id);
    }
}
