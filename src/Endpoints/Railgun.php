<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 23/10/2017
 * Time: 11:15
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Railgun implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function create(
        string $name
    ): \stdClass {
        $query = [
            'name' => $name,
        ];

        $user = $this->adapter->post('railguns', $query);
        $this->body = json_decode($user->getBody());

        return $this->body;
    }

    public function list(
        int $page = 1,
        int $perPage = 20,
        string $direction = ''
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage
        ];

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('railguns', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function get(
        string $railgunID
    ): \stdClass {
        $user = $this->adapter->get('railguns/' . $railgunID);
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }

    public function getZones(
        string $railgunID
    ): \stdClass {
        $user = $this->adapter->get('railguns/' . $railgunID . '/zones');
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function update(
        string $railgunID,
        bool $status
    ): \stdClass {
        $query = [
            'enabled' => $status
        ];

        $user = $this->adapter->patch('railguns/' . $railgunID, $query);
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }

    public function delete(
        string $railgunID
    ): bool {
        $user = $this->adapter->delete('railguns/' . $railgunID);
        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
