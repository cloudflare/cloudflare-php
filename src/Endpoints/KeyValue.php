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
        $body = $this->request('get', $uri, $query);

        return (object)[
            'result'      => $body->result,
            'result_info' => $body->result_info,
        ];
    }

    public function getKeyValue(string $accountId, string $namespaceId, string $key)
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', $accountId, $namespaceId, $key);
        return $this->request('get', $uri);
    }

    public function getKeyMetadata(string $accountId, string $namespaceId, string $key): ?stdClass
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/metadata/%s', $accountId, $namespaceId, $key);
        $body = $this->request('get', $uri);

        return $body->result;
    }

    public function setKeyValue(string $accountId, string $namespaceId, string $key, $value, array $metadata = [], int $expiration = null, int $expirationTtl = null): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', $accountId, $namespaceId, $key);
        $query = [
            'expiration' => $expiration,
            'expiration_ttl' => $expirationTtl,
        ];

        $headers = ['Content-Type' => 'text/plain'];
        $data = $value;

        if (!empty($metadata)) {
            $headers['Content-Type'] = 'multipart/form-data';
            $data = ['value' => $value, 'metadata' => $metadata];
        }

        $body = $this->request('put', $uri, $query, $data, $headers);

        return $body->success;
    }

    public function setMultipleKeysValues(string $accountId, string $namespaceId, array $data, array $metadata = [], int $expiration = null, int $expirationTtl = null): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/bulk', $accountId, $namespaceId);
        $bulkData = [];

        foreach ($data as $key => $value) {
            $bulkData[] = [
                'key' => $key,
                'value' => $value,
                'expiration' => $expiration,
                'expiration_ttl' => $expirationTtl,
                'metadata' => $metadata
            ];
        }

        $body = $this->request('put', $uri, [], $bulkData, ['Content-Type' => 'application/json']);

        return $body->success;
    }

    public function deleteKey(string $accountId, string $namespaceId, string $key): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', $accountId, $namespaceId, $key);

        $body = $this->request('delete', $uri);

        return $body->success;
    }

    public function deleteMultipleKeys(string $accountId, string $namespaceId, array $keys): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/bulk', $accountId, $namespaceId);

        $body = $this->request('delete', $uri, [], $keys, ['Content-Type' => 'application/json']);

        return $body->success;
    }

    protected function request(string $method, string $uri, array $query = [], $data = [], array $headers = [])
    {
        $method = strtolower($method);
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }
        $response      = $this->adapter->{$method}($uri, $data, $headers);
        $body =  json_decode($response->getBody());

        if ($body === null) {
            $body = (string) $response->getBody();
        } elseif (isset($body->success) && $body->success !== true) {
            if (!empty($body->errors)) {
                throw new KeyValueException($body->errors[0]->message, $body->errors[0]->code);
            }

            throw new KeyValueException('unknown error: ' . $response->getBody());
        }

        return $body;
    }
}
