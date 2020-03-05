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
                $this->equalTo([
                    'zone_id' => '023e105f4ecef8ad9ca31a8372d0c353',
                ])
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
    }

    public function testRevokeCertificate()
    {
    }

    public function testCreateCertificate()
    {
    }
}
