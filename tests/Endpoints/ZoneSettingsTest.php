<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\ZoneSettings;

class ZoneSettingsTest extends TestCase
{
    public function testGetServerSideExcludeSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getServerSideExclude.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getServerSideExcludeSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('on', $result);
    }

    public function testUpdateServerSideExcludeSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateServerSideExclude.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateServerSideExcludeSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertSame('on', $result);
    }

    public function testGetBrowserCacheTtlSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getBrowserCacheTtlSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getBrowserCacheTtlSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame(14400, $result);
    }

    public function testUpdateBrowserCacheTtlSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateBrowserCacheTtlSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateBrowserCacheTtlSetting('023e105f4ecef8ad9ca31a8372d0c353', 16070400);

        $this->assertTrue($result);
    }
}
