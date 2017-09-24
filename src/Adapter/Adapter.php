<?php
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 16:06
 */

namespace Cloudflare\API\Adapter;

use Cloudflare\API\Auth\Auth;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface Adapter
 * @package Cloudflare\API\Adapter
 * Note that the $body fields expect a JSON key value store.
 */
interface Adapter
{
    /**
     * Adapter constructor.
     *
     * @param Auth $auth
     * @param String $baseURI
     */
    public function __construct(Auth $auth, String $baseURI);

    /**
     * Sends a GET request.
     * Per Robustness Principle - not including the ability to send a body with a GET request (though possible in the
     * RFCs, it is never useful).
     *
     * @param String $uri
     * @param array $headers
     *
     * @return mixed
     */
    public function get(String $uri, array $query, array $headers): ResponseInterface;

    /**
     * @param String $uri
     * @param array $headers
     * @param array $body
     *
     * @return mixed
     */
    public function post(String $uri, array $headers, array $body): ResponseInterface;

    /**
     * @param String $uri
     * @param array $headers
     * @param array $body
     *
     * @return mixed
     */
    public function put(String $uri, array $headers, array $body): ResponseInterface;

    /**
     * @param String $uri
     * @param array $headers
     * @param array $body
     *
     * @return mixed
     */
    public function patch(String $uri, array $headers, array $body): ResponseInterface;

    /**
     * @param String $uri
     * @param array $headers
     * @param array $body
     *
     * @return mixed
     */
    public function delete(String $uri, array $headers, array $body): ResponseInterface;
}
