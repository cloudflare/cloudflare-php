<?php

namespace Cloudflare\API\Test\Auth;

use Cloudflare\API\Auth\None;
use Cloudflare\API\Test\TestCase;

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:08
 */

class NoneTest extends TestCase
{
    public function testGetHeaders()
    {
        $auth    = new None();
        $headers = $auth->getHeaders();

        $this->assertEquals([], $headers);
    }
}
