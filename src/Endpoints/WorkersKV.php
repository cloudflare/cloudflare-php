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

    public function createNamespace(string $accountID, string $namespace): \stdClass
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

    public function getReadKeyValuePair(string $accountID, $namespaceIdentifier, $keyName): string
    {
        $response = $this->adapter->get('accounts/' . $accountID . '/storage/kv/namespaces/' . $namespaceIdentifier . '/values/' . $keyName);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }

    public function getAllKeysAndValuesForNamespace(string $accountID, string $namespaceIdentifier)
    {
        $keys = $this->listNamespaceKeys($accountID, $namespaceIdentifier);
        foreach ($keys as $index => $values) {
            $value = $this->getReadKeyValuePair($accountID, $namespaceIdentifier, $values->name);
            $keys[$index]->value = $value;
        }
        return $keys;
    }

    public function getListOfNamespaces(string $accountID, int $page = 1, int $perPage = 50, string $order = '', string $direction = '')
    {
        $query = [
            'page' => $page,
            'per_page' => $perPage
        ];

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $namespace = $this->adapter->get('accounts/' . $accountID . '/storage/kv/namespaces', $query);
        $this->body = json_decode($namespace->getBody());
        return $this->body->result;
    }

    public function writeMultipleKeyValuePairs(string $accountID, $namespaceIdentifier, $keys = []): bool
    {
        $this->adapter->put('accounts/' . $accountID . '/storage/kv/namespaces/' . $namespaceIdentifier . '/bulk', $keys);
        return true;
    }

    public function deleteKeyValuePair(string $accountID, $namespaceIdentifier, string $key): bool
    {
        $this->adapter->delete('accounts/' . $accountID . '/storage/kv/namespaces/' . $namespaceIdentifier . '/values', [$key]);
        return true;
    }
}
