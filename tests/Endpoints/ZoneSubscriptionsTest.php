<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\ZoneSubscriptions;

class ZoneSubscriptionsTest extends TestCase
{
    public function testListZoneSubscriptions()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listZoneSubscriptions.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/subscriptions')
            );

        $zoneSubscriptions = new ZoneSubscriptions($mock);
        $zoneSubscriptions->listZoneSubscriptions('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertEquals('506e3185e9c882d175a2d0cb0093d9f2', $zoneSubscriptions->getBody()->result[0]->id);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zoneSubscriptions->getBody()->result[0]->zone->id);
    }

    public function testAddZoneSubscriptionIfMissing()
    {
        $postResponse = $this->getPsr7JsonResponseForFixture('Endpoints/createZoneSubscription.json');
        $getResponse = $this->getPsr7JsonResponseForFixture('Endpoints/listEmptyZoneSubscriptions.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($postResponse);
        $mock->method('get')->willReturn($getResponse);

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

    public function testAddZoneSubscriptionIfExisting()
    {
        $postResponse = $this->getPsr7JsonResponseForFixture('Endpoints/createZoneSubscription.json');
        $getResponse = $this->getPsr7JsonResponseForFixture('Endpoints/listZoneSubscriptions.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('put')->willReturn($postResponse);
        $mock->method('get')->willReturn($getResponse);

        $mock->expects($this->once())
            ->method('put')
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
