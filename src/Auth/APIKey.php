<?php
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 16:55
 */

namespace Cloudflare\API\Auth;

class APIKey implements Auth
{
    private $email;
    private $Authorization;

    public function __construct(string $email, string $Authorization)
    {
        $this->email  = $email;
        $this->Authorization = $Authorization;
    }

    public function getHeaders(): array
    {
        return [
            'X-Auth-Email'   => $this->email,
            'Authorization' => $this->Authorization
        ];
    }
}
