<?php

namespace Cloudflare\API\Configurations;

class Certificate implements Configurations
{
    const ORIGIN_RSA = 'origin-rsa';
    const ORIGIN_ECC = 'origin-ecc';
    const KEYLESS_CERTIFICATE = 'keyless-certificate';

    private $config = [];

    public function getArray(): array
    {
        return $this->config;
    }

    /**
     * Array of hostnames or wildcard names (e.g., *.example.com) bound to the certificate
     * Example: $hostnames = ["example.com", "foo.example.com"]
     * @param array $hostnames
     */
    public function setHostnames(array $hostnames)
    {
        $this->config['hostnames'] = $hostnames;
    }

    /**
     * The number of days for which the certificate should be valid
     * Default value: 5475
     * Valid values: 7, 30, 90, 365, 730, 1095, 5475
     * @param int $validity
     */
    public function setRequestedValidity(int $validity)
    {
        $this->config['requested_validity'] = $validity;
    }

    /**
     * Signature type desired on certificate ("origin-rsa" (rsa), "origin-ecc" (ecdsa), or "keyless-certificate" (for Keyless SSL servers)
     * Valid values: origin-rsa, origin-ecc, keyless-certificate
     * @param string $type
     */
    public function setRequestType(string $type)
    {
        $this->config['request_type'] = $type;
    }

    /**
     * The Certificate Signing Request (CSR). Must be newline-encoded.
     *
     * @param string $csr
     */
    public function setCsr(string $csr)
    {
        $this->config['csr'] = $csr;
    }
}
