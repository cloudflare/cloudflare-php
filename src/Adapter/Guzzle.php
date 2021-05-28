<?php

namespace Cloudflare\API\Adapter;

use Cloudflare\API\Auth\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Guzzle implements Adapter
{
    private $client;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth, string $baseURI = null)
    {
        if ($baseURI === null) {
            $baseURI = 'https://api.cloudflare.com/client/v4/';
        }

        $headers = $auth->getHeaders();

        $this->client = new Client([
            'base_uri' => $baseURI,
            'headers' => $headers,
            'Accept' => 'application/json'
        ]);
    }


    /**
     * @inheritDoc
     */
    public function get(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('get', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('post', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function put(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('put', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('patch', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('delete', $uri, $data, $headers);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function request(string $method, string $uri, array $data = [], array $headers = [])
    {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            throw new \InvalidArgumentException('Request method must be get, post, put, patch, or delete');
        }

        try {
            $response = $this->client->$method($uri, [
                'headers' => $headers,
                ($method === 'get' ? 'query' : 'json') => $data,
            ]);
        } catch (RequestException $err) {
            throw ResponseException::fromRequestException($err);
        }

        return $response;
    }
}
