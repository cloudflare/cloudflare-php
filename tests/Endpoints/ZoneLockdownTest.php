<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 21:23
 */
class ZoneLockdownTest extends PHPUnit_Framework_TestCase
{
    public function testListLockdowns()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": [
    {
      "id": "372e67954025e0ba6aaa6d586b9e0b59",
      "description": "Restrict access to these endpoints to requests from a known IP address",
      "urls": [
        "api.mysite.com/some/endpoint*"
      ],
      "configurations": [
        {
          "target": "ip",
          "value": "1.2.3.4"
        }
      ]
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
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/lockdowns'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20,
              ]),
              $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\ZoneLockdown($mock);
        $result = $zones->listLockdowns("023e105f4ecef8ad9ca31a8372d0c353", 1, 20);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
    }

    public function testAddLockdown()
    {
        $config = new \Cloudflare\API\Configurations\ZoneLockdown();
        $config->addIP('1.2.3.4');

        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "description": "Restrict access to these endpoints to requests from a known IP address",
    "urls": [
      "api.mysite.com/some/endpoint*"
    ],
    "configurations": [
      {
        "target": "ip",
        "value": "1.2.3.4"
      }
    ]
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/lockdowns'),
                $this->equalTo([]),
                $this->equalTo([
                    'urls' => ["api.mysite.com/some/endpoint*"],
                    'id' => '372e67954025e0ba6aaa6d586b9e0b59',
                    'description' => 'Restrict access to these endpoints to requests from a known IP address',
                    'configurations' => $config->getArray(),
                ])
            );

        $ld = new \Cloudflare\API\Endpoints\ZoneLockdown($mock);
        $ld->createLockdown(
            '023e105f4ecef8ad9ca31a8372d0c353',
            ["api.mysite.com/some/endpoint*"],
            $config,
            '372e67954025e0ba6aaa6d586b9e0b59',
            'Restrict access to these endpoints to requests from a known IP address'
        );
    }

    public function testGetRecordDetails()
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
    "description": "Restrict access to these endpoints to requests from a known IP address",
    "urls": [
      "api.mysite.com/some/endpoint*"
    ],
    "configurations": [
      {
        "target": "ip",
        "value": "1.2.3.4"
      }
    ]
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/lockdowns/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([])
            );

        $lockdown = new \Cloudflare\API\Endpoints\ZoneLockdown($mock);
        $result = $lockdown->getLockdownDetails("023e105f4ecef8ad9ca31a8372d0c353", "372e67954025e0ba6aaa6d586b9e0b59");

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->id);
    }

    public function testUpdateLockdown()
    {
        $config = new \Cloudflare\API\Configurations\ZoneLockdown();
        $config->addIP('1.2.3.4');

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
    "description": "Restrict access to these endpoints to requests from a known IP address",
    "urls": [
      "api.mysite.com/some/endpoint*"
    ],
    "configurations": [
      {
        "target": "ip",
        "value": "1.2.3.4"
      }
    ]
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/lockdowns/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([]),
                $this->equalTo([
                    'urls' => ["api.mysite.com/some/endpoint*"],
                    'id' => '372e67954025e0ba6aaa6d586b9e0b59',
                    'description' => 'Restrict access to these endpoints to requests from a known IP address',
                    'configurations' => $config->getArray(),
                ])
            );

        $ld = new \Cloudflare\API\Endpoints\ZoneLockdown($mock);
        $ld->updateLockdown(
            '023e105f4ecef8ad9ca31a8372d0c353',
            '372e67954025e0ba6aaa6d586b9e0b59',
            ["api.mysite.com/some/endpoint*"],
            $config,
            'Restrict access to these endpoints to requests from a known IP address'
        );
    }

    public function testDeleteLockdown()
    {
        $config = new \Cloudflare\API\Configurations\ZoneLockdown();
        $config->addIP('1.2.3.4');

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
    "id": "372e67954025e0ba6aaa6d586b9e0b59"
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/lockdowns/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $ld = new \Cloudflare\API\Endpoints\ZoneLockdown($mock);
        $ld->deleteLockdown('023e105f4ecef8ad9ca31a8372d0c353', '372e67954025e0ba6aaa6d586b9e0b59');
    }
}
