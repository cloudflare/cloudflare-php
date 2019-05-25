<?php

class CryptoTest extends TestCase
{
    public function testGetSSLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getSSLSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/ssl')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testGetSSLVerificationStatus()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getSSLVerificationStatus.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/ssl/verification')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getSSLVerificationStatus('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertEquals('active', $result->result{0}->certificate_status);
    }

    public function testGetOpportunisticEncryptionSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOpportunisticEncryptionSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/opportunistic_encryption')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getOpportunisticEncryptionSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testGetOnionRoutingSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOnionRoutingSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/opportunistic_onion')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getOnionRoutingSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testGetHTTPSRedirectSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getHTTPSRedirectSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/always_use_https')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getHTTPSRedirectSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testGetHTTPSRewritesSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getHTTPSRewritesSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/automatic_https_rewrites')
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->getHTTPSRewritesSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testUpdateSSLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateSSLSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/ssl'),
                $this->equalTo(['value' => 'full'])
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->updateSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'full');

        $this->assertTrue($result);
    }

    public function testUpdateHTTPSRedirectSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateHTTPSRedirectSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/always_use_https'),
                $this->equalTo(['value' => 'off'])
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->updateHTTPSRedirectSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

    public function testUpdateHTTPSRewritesSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateHTTPSRewritesSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/automatic_https_rewrites'),
                $this->equalTo(['value' => 'off'])
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->updateHTTPSRewritesSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

    public function testUpdateOpportunisticEncryptionSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateOpportunisticEncryptionSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/opportunistic_encryption'),
                $this->equalTo(['value' => 'off'])
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->updateOpportunisticEncryptionSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

    public function testUpdateOnionRoutingSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateOnionRoutingSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/opportunistic_onion'),
                $this->equalTo(['value' => 'off'])
            );

        $cryptoMock = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $cryptoMock->updateOnionRoutingSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

}
