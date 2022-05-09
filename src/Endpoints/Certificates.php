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

    /**
     * Get the certificate transparency monitoring configuration for the zone.
     *
     * @param string $zoneID
     * @return mixed
     */
    public function getCertificateTransparencyMonitoring(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/ct/alerting'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result;
        }
        return false;
    }
    
    /**
     * Update the certificate transparency monitoring configuration for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param bool $enabled Enabling of CT monitoring for the zone.
     * @param array $emails List of notification email address for this zone.
     * @return bool
     */
    public function updateCertificateTransparencyMonitoring(string $zoneID, bool $enabled = null, array $emails = [])
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/ct/alerting',
            [
                'enabled' => $enabled == true ? true : false,
                'emails' => $emails
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }
}
