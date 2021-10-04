<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\ZoneSubscriptions;

class ZoneSubscriptionsTest extends TestCase
{
    public function testAddZoneSubscription()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createZoneSubscription.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/subscription'),
                $this->equalTo([
                    'rate_plan' => [
                        'id' => 'PARTNER_PRO',
                    ],
                ])
            );

        $zoneSubscriptions = new ZoneSubscriptions($mock);
        $zoneSubscriptions->addZoneSubscription('023e105f4ecef8ad9ca31a8372d0c353', 'PARTNER_PRO');

        $this->assertEquals('506e3185e9c882d175a2d0cb0093d9f2', $zoneSubscriptions->getBody()->result->id);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zoneSubscriptions->getBody()->result->zone->id);
    }
}
