<?php

use PHPUnit\Framework\TestCase;
use Cloudflare\API\Configurations\Certificate;

class CertificateTest extends TestCase
{
    public function testGetArray()
    {
        $certificate = new Certificate();
        $certificate->setHostnames(['foo.com', '*.bar.com']);
        $certificate->setRequestType(Certificate::ORIGIN_ECC);
        $certificate->setRequestedValidity(365);
        $certificate->setCsr('some-csr-encoded-text');

        $array = $certificate->getArray();
        $this->assertEquals(['foo.com', '*.bar.com'], $array['hostnames']);
        $this->assertEquals('origin-ecc', $array['request_type']);
        $this->assertEquals(365, $array['requested_validity']);
        $this->assertEquals('some-csr-encoded-text', $array['csr']);
    }
}
