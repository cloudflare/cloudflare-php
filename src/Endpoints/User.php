<?php
/**
 * User: junade
 * Date: 01/02/2017
 * Time: 12:30
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class User implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getUserDetails(): \stdClass
    {
        $user = $this->adapter->get('user');
        $this->body = json_decode($user->getBody());
        return $this->body->result;
    }

    public function getUserID(): string
    {
        return $this->getUserDetails()->id;
    }

    public function getUserEmail(): string
    {
        return $this->getUserDetails()->email;
    }

    public function updateUserDetails(array $details): \stdClass
    {
        $response = $this->adapter->patch('user', $details);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }
}
