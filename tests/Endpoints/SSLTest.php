<?php

class SSLTest extends TestCase
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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->getSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->getSSLVerificationStatus('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertEquals('active', $result->result[0]->certificate_status);
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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->getHTTPSRedirectSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->getHTTPSRewritesSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->updateSSLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'full');

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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->updateHTTPSRedirectSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

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

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->updateHTTPSRewritesSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

    public function testUpdateSSLCertificatePackValidationMethod()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateSSLCertificatePackValidationMethod.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/ssl/verification/a77f8bd7-3b47-46b4-a6f1-75cf98109948'),
                $this->equalTo(['validation_method' => 'txt'])
            );

        $sslMock = new \Cloudflare\API\Endpoints\SSL($mock);
        $result = $sslMock->updateSSLCertificatePackValidationMethod('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'a77f8bd7-3b47-46b4-a6f1-75cf98109948', 'txt');

        $this->assertTrue($result);
    }
}
