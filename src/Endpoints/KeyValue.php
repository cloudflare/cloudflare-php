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
        return $this->request('get', $uri)->result;
    }

    public function getKeyMetadata(string $accountId, string $namespaceId, string $key)
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/metadata/%s', $accountId, $namespaceId, $key);
        return $this->request('get', $uri)->result;
    }

    public function setKeyValue(string $accountId, string $namespaceId, string $key, string $value, array $metadata = [], int $expiration = null, int $expirationTtl = null): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', $accountId, $namespaceId, $key);
        $query = [
            'expiration' => $expiration,
            'expiration_ttl' => $expirationTtl,
        ];

        $data = ['data' => $value];
        $headers = ['Content-Type' => 'text/plain'];

        if (!empty($metadata)) {
            $data = ['value' => $value, 'metadata' => $metadata];
            $headers = ['Content-Type' => 'multipart/form-data'];
        }

        return $this->request('put', $uri, $query, $data, $headers)->success;
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

        return $this->request('put', $uri, [], $bulkData, ['Content-Type' => 'application/json'])->success;
    }

    public function deleteKey(string $accountId, string $namespaceId, string $key): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', $accountId, $namespaceId, $key);

        return $this->request('delete', $uri)->success;
    }

    public function deleteMultipleKeys(string $accountId, string $namespaceId, array $keys): bool
    {
        $uri = sprintf('accounts/%s/storage/kv/namespaces/%s/bulk', $accountId, $namespaceId);

        $body = $this->request('delete', $uri, [], $keys, ['Content-Type' => 'application/json']);

        return $body->success;
    }

    protected function request(string $method, string $uri, array $query = [], array $data = [], array $headers = [])
    {
        $method = strtolower($method);
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }
        $response      = $this->adapter->{$method}($uri, $data, $headers);
        $body =  json_decode($response->getBody(), false);

        if (!isset($body->success) || $body->success !== true) {
            if (!empty($body->errors)) {
                throw new KeyValueException($body->errors[0]->message, $body->errors[0]->code);
            }

            throw new KeyValueException('unknown error');
        }

        return $body;
    }
}
