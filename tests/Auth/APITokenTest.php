<?php

/**
 * User: junade
 * Date: 13/01/2017
 * Time: 17:15
 */
class APITokenTest extends TestCase
{
    public function testGetHeaders()
    {
		$auth    = new \Cloudflare\API\Auth\APIToken('zKq9RDO6PbCjs6PRUXF3BoqFi3QdwY36C2VfOaRy');
		$headers = $auth->getHeaders();

		$this->assertArrayHasKey('Authorization', $headers);

		$this->assertEquals('Bearer zKq9RDO6PbCjs6PRUXF3BoqFi3QdwY36C2VfOaRy', $headers['Authorization']);

		$this->assertCount(1, $headers);
    }
}
