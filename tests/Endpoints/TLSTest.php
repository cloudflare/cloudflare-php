<?php

/**
 * Created by PhpStorm.
 * User: Jurgen Coetsiers
 * Date: 21/10/2018
 * Time: 09:09
 */

class TLSTest extends TestCase
{
    public function testEnableTLS13()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/enableTLS13.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_1_3'),
                $this->equalTo(['value' => 'on'])
            );

        $zoneTLSSettings = new \Cloudflare\API\Endpoints\TLS($mock);
        $result = $zoneTLSSettings->enableTLS13('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
    }

    public function testDisableTLS13()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/disableTLS13.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_1_3'),
                $this->equalTo(['value' => 'off'])
            );

        $zoneTLSSettings = new \Cloudflare\API\Endpoints\TLS($mock);
        $result = $zoneTLSSettings->disableTLS13('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
    }

    public function testChangeMinimimTLSVersion()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/changeMinimumTLSVersion.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/min_tls_version'),
                $this->equalTo(['value' => '1.1'])
            );

        $zoneTLSSettings = new \Cloudflare\API\Endpoints\TLS($mock);
        $result = $zoneTLSSettings->changeMinimumTLSVersion('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', '1.1');

        $this->assertTrue($result);
    }
}
