<?php

class CryptoTest extends TestCase
{
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
