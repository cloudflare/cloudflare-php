<?php

class FirewallSettingsTest extends TestCase
{
    public function testGetSecurityLevelSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getSecurityLevelSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level')
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->getSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('medium', $result);
    }

    public function testGetChallengeTTLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getChallengeTTLSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl')
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->getChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals(1800, $result);
    }

    public function testGetBrowserIntegrityCheckSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getBrowserIntegrityCheckSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check')
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->getBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('on', $result);
    }

    public function testUpdateSecurityLevelSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateSecurityLevelSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level'),
                $this->equalTo(['value' => 'medium'])
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->updateSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'medium');

        $this->assertTrue($result);
    }

    public function testUpdateChallengeTTLSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateChallengeTTLSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl'),
                $this->equalTo(['value' => 1800])
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->updateChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 1800);

        $this->assertTrue($result);
    }

    public function testUpdateBrowserIntegrityCheckSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateBrowserIntegrityCheckSetting.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check'),
                $this->equalTo(['value' => 'on'])
            );

        $firewallSettingsMock = new \Cloudflare\API\Endpoints\FirewallSettings($mock);
        $result = $firewallSettingsMock->updateBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'on');

        $this->assertTrue($result);
    }
}
