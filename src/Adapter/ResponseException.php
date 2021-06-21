<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 21/04/2017
 * Time: 07:23
 */

namespace Cloudflare\API\Adapter;

use GuzzleHttp\Exception\RequestException;

class ResponseException extends \Exception
{
    /**
     * Generates a ResponseException from a Guzzle RequestException.
     *
     * @param RequestException $err The client request exception (typicall 4xx or 5xx response).
     * @return ResponseException
     */
    public static function fromRequestException(RequestException $err): self
    {
        if (!$err->hasResponse()) {
            return new ResponseException($err->getMessage(), 0, $err);
        }

        $response = $err->getResponse();
        $contentType = $response->getHeaderLine('Content-Type');

        // Attempt to derive detailed error from standard JSON response.
        if (strpos($contentType, 'application/json') !== false) {
            $json = json_decode($response->getBody());
            if (json_last_error() !== JSON_ERROR_NONE) {
                return new ResponseException($err->getMessage(), 0, new JSONException(json_last_error_msg(), 0, $err));
            }

            if (isset($json->errors) && count($json->errors) >= 1) {
                return new ResponseException($json->errors[0]->message, $json->errors[0]->code, $err);
            }
        }

        return new ResponseException($err->getMessage(), 0, $err);
    }
}
