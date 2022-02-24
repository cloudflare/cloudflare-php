<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class KeyValue implements API
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

    public function listKeys(string $accountId, string $namespaceId, int $limit = null, string $cursor = null, string $prefix = null): stdClass
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/keys', $accountId, $namespaceId);
        $query = [
            'limit' => $limit,
            'cursor' => $cursor,
            'prefix' => $prefix
        ];
        $roles      = $this->adapter->get($uri, $query);
        $this->body = json_decode($roles->getBody());

        return (object)[
            'result'      => $this->body->result,
            'result_info' => $this->body->result_info,
        ];
    }
}
