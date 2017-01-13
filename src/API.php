<?php
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 16:34
 */

namespace Cloudflare\API;


use Cloudflare\API\Auth\Auth;

class API
{
    private $auth;

    public function __construct(Auth $auth, bool $verifyAuth = true)
    {
        $this->auth = $auth;
    }

    public function verifyAuth()
    {

    }
}