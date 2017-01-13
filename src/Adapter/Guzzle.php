<?php
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 18:26
 */

namespace Cloudflare\API\Adapter;


use Cloudflare\API\Auth\Auth;
use GuzzleHttp\Client;

class Guzzle implements Adapter
{
    private $client;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth, String $baseURI = "https://api.cloudflare.com/client/v4/")
    {
        $this->client = new Client([
            'base_uri' => $baseURI
        ]);
    }


    /**
     * @inheritDoc
     */
    public function get(String $uri, array $headers = array())
    {
        $response = $this->client->get($uri, $headers);
        var_dump((string)$response);

    }

    /**
     * @inheritDoc
     */
    public function post(String $uri, array $headers = array(), array $body = array())
    {
        // TODO: Implement post() method.
    }

    /**
     * @inheritDoc
     */
    public function put(String $uri, array $headers = array(), array $body = array())
    {
        // TODO: Implement put() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(String $uri, array $headers = array(), array $body = array())
    {
        // TODO: Implement delete() method.
    }
}