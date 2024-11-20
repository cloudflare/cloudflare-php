<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class UserInvites implements API
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

    public function respondToInvite(string $inviteId, string $status)
    {
        $options = [
            'status' => $status,
        ];

        $invite     = $this->adapter->patch('user/invites/' . $inviteId, $options);
        $this->body = json_decode($invite->getBody());

        return $this->body->result;
    }
}
