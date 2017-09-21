<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 15:19
 */

use Cloudflare\API\Endpoints\UARules;

class UARulesTest extends PHPUnit_Framework_TestCase
{
    public function testListRules()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [
    {}
  ],
  "messages": [
    {}
  ],
  "result": [
    {
      "id": "372e67954025e0ba6aaa6d586b9e0b59",
      "description": "Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack",
      "mode": "js_challenge",
      "configuration": {
        "target": "ua",
        "value": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4"
      }
    }
  ],
  "result_info": {
    "page": 1,
    "per_page": 20,
    "count": 1,
    "total_count": 2000
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/ua_rules'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20
              ]),
              $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\UARules($mock);
        $result = $zones->listRules("023e105f4ecef8ad9ca31a8372d0c353", 1, 20);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
    }

    public function testCreateRule()
    {
        $config = new \Cloudflare\API\Configurations\UARules();
        $config->addUA('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4');

        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [
    {}
  ],
  "messages": [
    {}
  ],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "description": "Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack",
    "mode": "js_challenge",
    "configuration": {
      "target": "ua",
      "value": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4"
    }
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/ua_rules'), $this->equalTo([]),
                $this->equalTo([
                    'mode' => 'js_challenge',
                    'id' => '372e67954025e0ba6aaa6d586b9e0b59',
                    'description' => 'Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack',
                    'configurations' => $config->getArray(),
                ])
            );

        $ld = new \Cloudflare\API\Endpoints\UARules($mock);
        $ld->createRule('023e105f4ecef8ad9ca31a8372d0c353', 'js_challenge', $config,
            '372e67954025e0ba6aaa6d586b9e0b59',
            'Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack');
    }

    public function getRuleDetails()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [
    {}
  ],
  "messages": [
    {}
  ],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "description": "Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack",
    "mode": "js_challenge",
    "configuration": {
      "target": "ua",
      "value": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4"
    }
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/ua_rules/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([])
            );

        $lockdown = new \Cloudflare\API\Endpoints\UARules($mock);
        $result = $lockdown->getRuleDetails("023e105f4ecef8ad9ca31a8372d0c353", "372e67954025e0ba6aaa6d586b9e0b59");

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->id);
    }

    public function testUpdateRule()
    {
        $config = new \Cloudflare\API\Configurations\UARules();
        $config->addUA('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4');

        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [
    {}
  ],
  "messages": [
    {}
  ],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "description": "Prevent access from abusive clients identified by this UserAgent to mitigate DDoS attack",
    "mode": "js_challenge",
    "configuration": {
      "target": "ua",
      "value": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4"
    }
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/ua_rules/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([]),
                $this->equalTo([
                    'mode' => 'js_challenge',
                    'id' => '372e67954025e0ba6aaa6d586b9e0b59',
                    'description' => 'Restrict access to these endpoints to requests from a known IP address',
                    'configurations' => $config->getArray(),
                ])
            );

        $ld = new \Cloudflare\API\Endpoints\UARules($mock);
        $ld->updateRule('023e105f4ecef8ad9ca31a8372d0c353', '372e67954025e0ba6aaa6d586b9e0b59',
            'js_challenge', $config,
            'Restrict access to these endpoints to requests from a known IP address');
    }

    public function testDeleteRule()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [
    {}
  ],
  "messages": [
    {}
  ],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59"
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/ua_rules/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $ld = new \Cloudflare\API\Endpoints\UARules($mock);
        $ld->deleteRule('023e105f4ecef8ad9ca31a8372d0c353', '372e67954025e0ba6aaa6d586b9e0b59');
    }
}
