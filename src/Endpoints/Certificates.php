<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\Certificate as CertificateConfig;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Certificates implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * List all existing Origin CA certificates for a given zone
     *
     * @param string $zoneID
     * @return array
     */
    public function listCertificates(string $zoneID): \stdClass
    {
        $certificates = $this->adapter->get('certificates', ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        return (object)['result' => $this->body->result];
    }

    /**
     * Get an existing Origin CA certificate by its serial number
     *
     * @param string $certificateID
     * @param string $zoneID
     * @return mixed
     */
    public function getCertificate(string $certificateID, string $zoneID)
    {
        $certificates = $this->adapter->get('certificates/'.$certificateID, ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        return (object)['result' => $this->body->result];
    }

    /**
     * Revoke an existing Origin CA certificate by its serial number
     *
     * @param string $certificateID
     * @param string $zoneID
     * @return bool
     */
    public function revokeCertificate(string $certificateID, string $zoneID): bool
    {
        $certificates = $this->adapter->delete('certificates/'.$certificateID, ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * Create an Origin CA certificate
     *
     * @param CertificateConfig $config
     * @return bool
     */
    public function createCertificate(CertificateConfig $config): bool
    {
        $certificate = $this->adapter->post('certificates', $config->getArray());

        $this->body = json_decode($certificate->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
