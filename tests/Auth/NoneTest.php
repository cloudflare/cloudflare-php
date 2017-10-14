<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:08
 */

use Cloudflare\API\Auth\None;
use PHPUnit_Framework_TestCase as TestBase;

class NoneTest extends TestBase
{
    public function testGetHeaders()
    {
        $auth    = new \Cloudflare\API\Auth\None();
        $headers = $auth->getHeaders();

        $this->assertEquals([], $headers);
    }
}
