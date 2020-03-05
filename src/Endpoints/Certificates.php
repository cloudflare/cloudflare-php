<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Certificates implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function listCertificates(string $zoneID): array
    {
        $certificates = $this->adapter->get('/certificates', ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        return $this->body->result;
    }

    public function getCertificate(string $certificateID, string $zoneID)
    {
        $certificates = $this->adapter->get('/certificates/' . $certificateID, ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        return $this->body->result;
    }

    public function revokeCertificate(string $certificateID, string $zoneID)
    {
        $certificates = $this->adapter->delete('/certificates/' . $certificateID, ['zone_id' => $zoneID]);
        $this->body = json_decode($certificates->getBody());

        return $this->body->result;
    }

    public function createCertificate(string $zoneID)
    {

    }
}