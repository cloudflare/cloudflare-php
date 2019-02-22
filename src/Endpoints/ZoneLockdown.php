<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:33
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class ZoneLockdown implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function listLockdowns(
        string $zoneID,
        int $page = 1,
        int $perPage = 20
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage
        ];

        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/lockdowns', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function createLockdown(
        string $zoneID,
        array $urls,
        \Cloudflare\API\Configurations\ZoneLockdown $configuration,
        string $lockdownID = null,
        string $description = null
    ): bool {
        $options = [
            'urls' => $urls,
            'configurations' => $configuration->getArray()
        ];

        if ($lockdownID !== null) {
            $options['id'] = $lockdownID;
        }

        if ($description !== null) {
            $options['description'] = $description;
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/firewall/lockdowns', $options);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function getLockdownDetails(string $zoneID, string $lockdownID): \stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/lockdowns/' . $lockdownID);
        $this->body = json_decode($user->getBody());
        return $this->body->result;
    }

    public function updateLockdown(
        string $zoneID,
        string $lockdownID,
        array $urls,
        \Cloudflare\API\Configurations\ZoneLockdown $configuration,
        string $description = null
    ): bool {
        $options = [
            'urls' => $urls,
            'id' => $lockdownID,
            'configurations' => $configuration->getArray()
        ];

        if ($description !== null) {
            $options['description'] = $description;
        }

        $user = $this->adapter->put('zones/' . $zoneID . '/firewall/lockdowns/' . $lockdownID, $options);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function deleteLockdown(string $zoneID, string $lockdownID): bool
    {
        $user = $this->adapter->delete('zones/' . $zoneID . '/firewall/lockdowns/' . $lockdownID);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
