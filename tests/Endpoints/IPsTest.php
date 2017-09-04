<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:16
 */

use Cloudflare\API\Endpoints\IPs;

class IPsTest extends PHPUnit_Framework_TestCase
{
    public function testGet() {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "ipv4_cidrs": [
      "199.27.128.0/21"
    ],
    "ipv6_cidrs": [
      "2400:cb00::/32"
    ]
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('ips'), $this->equalTo([])
            );

        $ips = new \Cloudflare\API\Endpoints\IPs($mock);
        $ips = $ips->get();
        $this->assertObjectHasAttribute("ipv4_cidrs", $ips);
        $this->assertObjectHasAttribute("ipv6_cidrs", $ips);
    }
}
