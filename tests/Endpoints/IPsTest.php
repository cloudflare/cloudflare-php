<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:16
 */

use Cloudflare\API\Endpoints\IPs;
use \Helpers\Guzzle as Guzzle;
use PHPUnit_Framework_TestCase as TestBase;
class IPsTest extends TestBase
{
    public function testListIPs()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/listIPs.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('ips'),
                $this->equalTo([])
            );

        $ips = new \Cloudflare\API\Endpoints\IPs($mock);
        $ips = $ips->listIPs();
        $this->assertObjectHasAttribute("ipv4_cidrs", $ips);
        $this->assertObjectHasAttribute("ipv6_cidrs", $ips);
    }
}
