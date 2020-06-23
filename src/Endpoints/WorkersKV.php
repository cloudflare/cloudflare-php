<?php

/**
 * User: junade
 * Date: 01/02/2017
 * Time: 12:30
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class WorkersKV implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function createNamespace(string $accountID, string $namespace): object
    {
        $response = $this->adapter->post(
            'accounts/' . $accountID . '/storage/kv/namespaces',
            ['title' => $namespace]
        );
        $this->body = json_decode($response->getBody());
        return $this->body->result;
    }

    public function getNameSpaces(string $accountID): array
    {
        $response = $this->adapter->get('accounts/' . $accountID . '/storage/kv/namespaces');
        $this->body = json_decode($response->getBody());
        return $this->body->result;
    }

    public function listNamespaceKeys(string $accountID, $namespaceIdentifier): array
    {
        $response = $this->adapter->get('accounts/' . $accountID . '/storage/kv/namespaces/' . $namespaceIdentifier . '/keys');
        $this->body = json_decode($response->getBody());
        return $this->body->result;
    }

    public function getListOfNamespaces(string $accountID)
    {
        $namespace = $this->adapter->get('accounts/' . $accountID . '/storage/kv/namespaces?per_page=100');
        $this->body = json_decode($namespace->getBody());
        return $this->body->result;
    }

    public function writeMultipleKeyValuePairs(string $accountID, $namespaceIdentifier, $keys = []): bool
    {
        $this->adapter->put('accounts/' . $accountID . '/storage/kv/namespaces/' . $namespaceIdentifier . '/bulk', $keys);
        return true;
    }
}
