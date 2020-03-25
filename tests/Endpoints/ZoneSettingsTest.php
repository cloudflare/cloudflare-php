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
    
    public function testGetIPGeolocationSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getIPGeolocationSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getIPGeolocationSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('on', $result);
    }
    
    public function testGetMirageSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getMirageSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getMirageSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetPolishSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPolishSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getPolishSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('lossless', $result);
    }
    
    public function testGetWebPSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWebPSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getWebPSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetBrotliSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getBrotliSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getBrotliSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetResponseBufferingSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getResponseBufferingSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getResponseBufferingSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetHTTP2Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getHTTP2Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getHTTP2Setting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetHTTP3Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getHTTP3Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getHTTP3Setting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGet0RTTSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/get0RTTSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->get0RTTSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetPseudoIPv4Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPseudoIPv4Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getPseudoIPv4Setting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetWebSocketSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWebSocketSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $zones = new ZoneSettings($mock);
        $result = $zones->getWebSocketSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
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

    public function testUpdateIPGeolocationSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateIPGeolocationSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateIPGeolocationSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testMirageSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateMirageSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateMirageSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdatePolishSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePolishSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updatePolishSetting('023e105f4ecef8ad9ca31a8372d0c353', 'lossy');

        $this->assertTrue($result);
    }

    public function testWebPSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateWebPSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateWebPSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdateBrotliSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateBrotliSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateBrotliSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdateResponseBufferingSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateResponseBufferingSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateResponseBufferingSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testHTTP2Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateHTTP2Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateHTTP2Setting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdateHTTP3Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateHTTP3Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateHTTP3Setting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdate0RTTSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/update0RTTSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->update0RTTSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdatePseudoIPv4Setting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePseudoIPv4Setting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updatePseudoIPv4Setting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }

    public function testUpdateWebSocketSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateWebSocketSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())->method('patch');

        $zones = new ZoneSettings($mock);
        $result = $zones->updateWebSocketSetting('023e105f4ecef8ad9ca31a8372d0c353', 'on');

        $this->assertTrue($result);
    }
}
