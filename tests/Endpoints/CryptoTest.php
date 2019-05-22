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

        $zoneSSLSetting = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $zoneSSLSetting->getSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

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

        $zoneVerificationStatus = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $zoneVerificationStatus->getSSLVerificationStatus('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertEquals('active', $result->result{0}->certificate_status);
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

        $zoneSSLSetting = new \Cloudflare\API\Endpoints\Crypto($mock);
        $result = $zoneSSLSetting->updateSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'full');

        $this->assertTrue($result);
    }


}
