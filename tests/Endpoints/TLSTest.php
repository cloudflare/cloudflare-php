<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\TLS;

/**
 * Created by PhpStorm.
 * User: Jurgen Coetsiers
 * Date: 21/10/2018
 * Time: 09:09
 */

class TLSTest extends TestCase
{
    public function testGetTLSClientAuth()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getTLSClientAuth.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_client_auth')
            );

        $tlsMock = new TLS($mock);
        $result = $tlsMock->getTLSClientAuth('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('off', $result);
    }

    public function testEnableTLS13()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/enableTLS13.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_1_3'),
                $this->equalTo(['value' => 'on'])
            );

        $tlsMock = new TLS($mock);
        $result = $tlsMock->enableTLS13('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
    }

    public function testDisableTLS13()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/disableTLS13.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_1_3'),
                $this->equalTo(['value' => 'off'])
            );

        $tlsMock = new TLS($mock);
        $result = $tlsMock->disableTLS13('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
    }

    public function testChangeMinimimTLSVersion()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/changeMinimumTLSVersion.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/min_tls_version'),
                $this->equalTo(['value' => '1.1'])
            );

        $tlsMock = new TLS($mock);
        $result = $tlsMock->changeMinimumTLSVersion('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', '1.1');

        $this->assertTrue($result);
    }

    public function testUpdateTLSClientAuth()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateTLSClientAuth.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/tls_client_auth'),
                $this->equalTo(['value' => 'off'])
            );

        $tlsMock = new TLS($mock);
        $result = $tlsMock->updateTLSClientAuth('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }
}
