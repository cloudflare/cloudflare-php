<?php
/**
 * User: czPechy
 * Date: 30/07/2018
 * Time: 22:42
 */

namespace Cloudflare\API\Auth;

class APIToken implements Auth
{
    private $apiToken;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiToken
        ];
    }
}
