<?php
/**
 * User: andrasbari
 * Date: 2023-02-12
 * Time: 17:16
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class DNSSEC implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $zoneID
     * @return \stdClass|null
     */
    public function getDetails(string $zoneID): ?\stdClass
    {
        $dnssec = $this->adapter->get('zones/' . $zoneID . '/dnssec');
        $this->body = json_decode($dnssec->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @return \stdClass|null
     */
    public function enable(string $zoneID): ?\stdClass
    {
        $response = $this->adapter->patch('zones/' . $zoneID. '/dnssec', ['status' => 'active']);
        $this->body = json_decode($response->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @return \stdClass|null
     */
    public function disable(string $zoneID): ?\stdClass
    {
        $response = $this->adapter->patch('zones/' . $zoneID. '/dnssec', ['status' => 'disabled']);
        $this->body = json_decode($response->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @return bool true if delete was successful
     */
    public function delete(string $zoneID): bool
    {
        $dnssec = $this->adapter->delete('zones/' . $zoneID . '/dnssec');
        $this->body = json_decode($dnssec->getBody());
        return $this->body->success;
    }
}
