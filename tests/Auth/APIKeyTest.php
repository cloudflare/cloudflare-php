<?php

namespace Cloudflare\API\Test\Auth;

use Cloudflare\API\Auth\APIKey;
use PHPUnit\Framework\TestCase;

/**
 * User: junade
 * Date: 13/01/2017
 * Time: 17:15
 */
class APIKeyTest extends TestCase
{
    public function testGetHeaders()
    {
        $auth    = new APIKey('example@example.com', '1234567893feefc5f0q5000bfo0c38d90bbeb');
        $headers = $auth->getHeaders();

        $this->assertArrayHasKey('X-Auth-Key', $headers);
        $this->assertArrayHasKey('X-Auth-Email', $headers);

        $this->assertEquals('example@example.com', $headers['X-Auth-Email']);
        $this->assertEquals('1234567893feefc5f0q5000bfo0c38d90bbeb', $headers['X-Auth-Key']);

        $this->assertCount(2, $headers);
    }
}
