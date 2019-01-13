<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

/* A list of memberships of accounts this user can access */

class Membership implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }


    public function listMemberships(
        string $name = '',
        string $status = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = ''
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage
        ];

        if (!empty($name)) {
            $query['account.name'] = $name;
        }

        if (!empty($status) && in_array($status, ['accepted', 'pending', 'rejected'], true)) {
            $query['status'] = $status;
        }

        if (!empty($order) && in_array($order, ['id', 'account.name', 'status'], true)) {
            $query['order'] = $order;
        }

        if (!empty($direction) && in_array($direction, ['asc', 'desc'], true)) {
            $query['direction'] = $direction;
        }

        $memberships = $this->adapter->get('memberships', $query);
        $this->body = json_decode($memberships->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getMembershipDetails(string $membershipId): \stdClass
    {
        $membership = $this->adapter->get(sprintf('memberships/%s', $membershipId));
        $this->body = json_decode($membership->getBody());
        return $this->body->result;
    }

    public function updateMembershipStatus(string $membershipId, string $status): \stdClass
    {
        $response = $this->adapter->put(sprintf('memberships/%s', $membershipId), ['status' => $status]);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }

    public function deleteMembership(string $membershipId): bool
    {
        $response = $this->adapter->delete(sprintf('memberships/%s', $membershipId));

        $this->body = json_decode($response->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
