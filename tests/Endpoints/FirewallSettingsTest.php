<?php

namespace Cloudflare\API\Test\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\FirewallSettings;
use Cloudflare\API\Test\TestCase;

class FirewallSettingsTest extends TestCase
{
    public function testGetSecurityLevelSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getSecurityLevelSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level')
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('medium', $result);
    }

    public function testGetChallengeTTLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getChallengeTTLSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl')
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals(1800, $result);
    }

    public function testGetBrowserIntegrityCheckSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getBrowserIntegrityCheckSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check')
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('on', $result);
    }

    public function testUpdateSecurityLevelSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateSecurityLevelSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level'),
                $this->equalTo(['value' => 'medium'])
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'medium');

        $this->assertTrue($result);
    }

    public function testUpdateChallengeTTLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateChallengeTTLSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl'),
                $this->equalTo(['value' => 1800])
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 1800);

        $this->assertTrue($result);
    }

    public function testUpdateBrowserIntegrityCheckSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateBrowserIntegrityCheckSetting.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check'),
                $this->equalTo(['value' => 'on'])
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'on');

        $this->assertTrue($result);
    }
}
