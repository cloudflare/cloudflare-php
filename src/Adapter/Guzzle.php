<?php
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 18:26
 */

namespace Cloudflare\API\Adapter;


use Cloudflare\API\Auth\Auth;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Guzzle implements Adapter
{
    private $client;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth, String $baseURI = "https://api.cloudflare.com/client/v4/")
    {
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
    public function get(String $uri, array $headers = array()): ResponseInterface
    {
        $response = $this->client->get($uri, ['headers' => $headers]);

        $this->checkError($response);
        return $response;

    }

    /**
     * @inheritDoc
     */
    public function post(String $uri, array $headers = array(), array $body = array()): ResponseInterface
    {
        $response = $this->client->post($uri, [
                'headers' => $headers,
                'json' => $body
            ]
        );

        $this->checkError($response);
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function put(String $uri, array $headers = array(), array $body = array()): ResponseInterface
    {
        $jsonBody = json_encode($body);

        $response = $this->client->put($uri, [
                'headers' => $headers,
                'body' => $jsonBody
            ]
        );

        $this->checkError($response);
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function patch(String $uri, array $headers = array(), array $body = array()): ResponseInterface
    {
        $jsonBody = json_encode($body);

        $response = $this->client->patch($uri, [
                'headers' => $headers,
                'body' => $jsonBody
            ]
        );

        $this->checkError($response);
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function delete(String $uri, array $headers = array(), array $body = array()): ResponseInterface
    {
        $response = $this->client->delete($uri, [
                'headers' => $headers,
                'form_params' => $body
            ]
        );

        $this->checkError($response);
        return $response;
    }

    private function checkError(ResponseInterface $response)
    {
        $json = json_decode($response->getBody());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JSONException();
        }

        if (isset($json->errors)) {
            foreach ($json->errors as $error) {
                throw new ResponseException($error->message, $error->code);
            }
        }

        if (isset($json->success) && ($json->success === false)) {
            throw new ResponseException("Request was unsuccessful.");
        }
    }
}
