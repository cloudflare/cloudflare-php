<?php

use Cloudflare\API\Endpoints\Certificates;

class CertificatesTest extends TestCase
{
    public function testListCertificates()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listCertificates.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('certificates'),
                $this->equalTo(
                    [
                        'zone_id' => '023e105f4ecef8ad9ca31a8372d0c353',
                    ]
                )
            );

        $certEndpoint = new Certificates($mock);
        $result = $certEndpoint->listCertificates('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertObjectHasAttribute('result', $result);

        $cert = $result->result[0];
        $this->assertEquals('328578533902268680212849205732770752308931942346', $cert->id);
        $this->assertEquals('origin-rsa', $cert->request_type);
        $this->assertEquals(5475, $cert->requested_validity);
        $this->assertEquals(['example.com', '*.example.com'], $cert->hostnames);
        $this->assertEquals('some-cert-data', $cert->certificate);
        $this->assertEquals('some-csr-data', $cert->csr);
    }

    public function testGetCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCertificate.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('certificates/6666699999996666699999999966666666'),
                $this->equalTo(['zone_id' => '023e105f4ecef8ad9ca31a8372d0c353']),
                $this->equalTo([])
            );

        $certEndpoint = new Certificates($mock);
        $response = $certEndpoint->getCertificate(
            '6666699999996666699999999966666666',
            '023e105f4ecef8ad9ca31a8372d0c353'
        );

        $this->assertObjectHasAttribute('result', $response);
        $cert = $response->result;
        $this->assertEquals('6666699999996666699999999966666666', $cert->id);
        $this->assertEquals('origin-ecc', $cert->request_type);
        $this->assertEquals(5475, $cert->requested_validity);
        $this->assertEquals(['foo.example.com', 'bar.example.com'], $cert->hostnames);
        $this->assertEquals('some-cert-data-foobar', $cert->certificate);
        $this->assertEquals('some-csr-data-foobar', $cert->csr);
    }

    public function testRevokeCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCertificate.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('certificates/11112222233333444455555'),
                $this->equalTo(['zone_id' => '023e105f4ecef8ad9ca31a8372d0c353']),
                $this->equalTo([])
            );

        $certEndpoint = new Certificates($mock);
        $result = $certEndpoint->revokeCertificate(
            '11112222233333444455555',
            '023e105f4ecef8ad9ca31a8372d0c353'
        );

        $this->assertTrue($result);
    }

    public function testCreateCertificate()
    {
        $certificate = new \Cloudflare\API\Configurations\Certificate();
        $certificate->setHostnames(['foo.example.com', 'bar.exapmle.com']);
        $certificate->setRequestType(\Cloudflare\API\Configurations\Certificate::ORIGIN_ECC);
        $certificate->setRequestedValidity(365);
        $certificate->setCsr('some-csr-data-barbar');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCertificate.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('certificates'),
                $this->equalTo($certificate->getArray()),
                $this->equalTo([])
            );

        $certEndpoint = new Certificates($mock);
        $result = $certEndpoint->createCertificate($certificate);

        $this->assertTrue($result);
    }
}
