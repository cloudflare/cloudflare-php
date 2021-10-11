<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class AccountMembers implements API
{
    use BodyAccessorTrait;

    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addAccountMember(string $accountId, string $email, array $roles): \stdClass
    {
        $options = [
            'email' => $email,
            'roles' => $roles,
        ];

        $account    = $this->adapter->post('accounts/' . $accountId . '/members', $options);
        $this->body = json_decode($account->getBody());

        return $this->body->result;
    }

    public function listAccountMembers(string $accountId, int $page = 1, int $perPage = 20): \stdClass
    {
        $query = [
            'page'     => $page,
            'per_page' => $perPage,
        ];

        $zone       = $this->adapter->get('accounts/' . $accountId . '/members', $query);
        $this->body = json_decode($zone->getBody());

        return (object)[
            'result'      => $this->body->result,
            'result_info' => $this->body->result_info,
        ];
    }
}
