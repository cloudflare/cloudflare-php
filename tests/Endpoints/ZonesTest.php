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
                $this->equalTo(['name' => 'example.com', 'jump_start' => false])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->addZone('example.com');

        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result->id);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createPageRule.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones'),
                $this->equalTo([
                    'name' => 'example.com',
                    'jump_start' => true,
                    'account'      => [
                        'id' => '01a7362d577a6c3019a474fd6f485823',
                    ],
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $zones->addZone('example.com', true, '01a7362d577a6c3019a474fd6f485823');
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $zones->getBody()->result->id);
    }

    public function testAddZoneWithAccountId()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addZone.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones'),
                $this->equalTo([
                    'name'       => 'example.com',
                    'jump_start' => false,
                    'account'    => [
                        'id' => '023e105f4ecef8ad9ca31a8372d0c353',
                    ],
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->addZone('example.com', false, '023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result->account->id);
    }

    public function testActivationTest()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/activationTest.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/activation_check')
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->activationCheck('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
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
                    'direction' => 'desc',
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->listZones('example.com', 'active', 1, 20, 'status', 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result[0]->id);
    }

    public function testGetZoneByID()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getZoneById.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
             ->method('get')
             ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353'));

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->getZoneById('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
        $this->assertEquals('example.com', $zones->getBody()->result->name);
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
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->getZoneID('example.com');

        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result[0]->id);
    }

    public function testGetAnalyticsDashboard()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getAnalyticsDashboard.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/analytics/dashboard'),
                $this->equalTo(['since' => '-10080', 'until' => '0', 'continuous' => var_export(true, true)])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $analytics = $zones->getAnalyticsDashboard('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertObjectHasAttribute('since', $analytics->totals);
        $this->assertObjectHasAttribute('since', $analytics->timeseries[0]);
    }

    public function testChangeDevelopmentMode()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/changeDevelopmentMode.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/development_mode'),
                $this->equalTo(['value' => 'on'])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->changeDevelopmentMode('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
        $this->assertEquals('development_mode', $zones->getBody()->result->id);
    }
}
