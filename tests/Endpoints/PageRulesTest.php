<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 19:25
 */

use Cloudflare\API\Adapter\PageRules;

class PageRulesTest extends PHPUnit_Framework_TestCase
{
    public function testCreatePageRule()
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
    "id": "9a7806061c88ada191ed06f989cc3dac",
    "targets": [
      {
        "target": "url",
        "constraint": {
          "operator": "matches",
          "value": "*example.com/images/*"
        }
      }
    ],
    "actions": [
      {
        "id": "always_online",
        "value": "on"
      }
    ],
    "priority": 1,
    "status": "active",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "created_on": "2014-01-01T05:20:00.12345Z"
  }
}');
        $target = new \Cloudflare\API\Configurations\PageRulesTargets('*example.com/images/*');
        $action = new \Cloudflare\API\Configurations\PageRulesActions();
        $action->setAlwaysOnline(true);

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules'),
                $this->equalTo([]),
                $this->equalTo([
                    'targets' => $target->getArray(),
                    'actions' => $action->getArray(),
                    'status' => 'active',
                    'priority' => 1
                ])
            );

        $pr = new \Cloudflare\API\Endpoints\PageRules($mock);
        $result = $pr->createPageRule('023e105f4ecef8ad9ca31a8372d0c353', $target, $action, true, 1);

        $this->assertTrue($result);
    }

    public function testListPageRules()
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
      "id": "9a7806061c88ada191ed06f989cc3dac",
      "targets": [
        {
          "target": "url",
          "constraint": {
            "operator": "matches",
            "value": "*example.com/images/*"
          }
        }
      ],
      "actions": [
        {
          "id": "always_online",
          "value": "on"
        }
      ],
      "priority": 1,
      "status": "active",
      "modified_on": "2014-01-01T05:20:00.12345Z",
      "created_on": "2014-01-01T05:20:00.12345Z"
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
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules'),
              $this->equalTo([
                'status' => 'active',
                'order' => 'status',
                'direction' => 'desc',
                'match' => 'all'
              ]),
              $this->equalTo([])
            );

        $pr = new \Cloudflare\API\Endpoints\PageRules($mock);
        $pr->listPageRules('023e105f4ecef8ad9ca31a8372d0c353', 'active', 'status', 'desc', 'all');
    }

    public function testGetPageRuleDetails()
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
    "id": "9a7806061c88ada191ed06f989cc3dac",
    "targets": [
      {
        "target": "url",
        "constraint": {
          "operator": "matches",
          "value": "*example.com/images/*"
        }
      }
    ],
    "actions": [
      {
        "id": "always_online",
        "value": "on"
      }
    ],
    "priority": 1,
    "status": "active",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "created_on": "2014-01-01T05:20:00.12345Z"
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules/9a7806061c88ada191ed06f989cc3dac'),
                $this->equalTo([])
            );

        $pr = new \Cloudflare\API\Endpoints\PageRules($mock);
        $pr->getPageRuleDetails('023e105f4ecef8ad9ca31a8372d0c353', '9a7806061c88ada191ed06f989cc3dac');
    }

    public function testUpdatePageRule()
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
    "id": "9a7806061c88ada191ed06f989cc3dac",
    "targets": [
      {
        "target": "url",
        "constraint": {
          "operator": "matches",
          "value": "*example.com/images/*"
        }
      }
    ],
    "actions": [
      {
        "id": "always_online",
        "value": "on"
      }
    ],
    "priority": 1,
    "status": "active",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "created_on": "2014-01-01T05:20:00.12345Z"
  }
}');
        $target = new \Cloudflare\API\Configurations\PageRulesTargets('*example.com/images/*');
        $action = new \Cloudflare\API\Configurations\PageRulesActions();
        $action->setAlwaysOnline(true);

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules'),
                $this->equalTo([]),
                $this->equalTo([
                    'targets' => $target->getArray(),
                    'actions' => $action->getArray(),
                    'status' => 'active',
                    'priority' => 1
                ])
            );

        $pr = new \Cloudflare\API\Endpoints\PageRules($mock);
        $result = $pr->updatePageRule('023e105f4ecef8ad9ca31a8372d0c353', $target, $action, true, 1);

        $this->assertTrue($result);
    }

    public function testDeletePageRule()
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
    "id": "9a7806061c88ada191ed06f989cc3dac"
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules/9a7806061c88ada191ed06f989cc3dac'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $pr = new \Cloudflare\API\Endpoints\PageRules($mock);
        $result = $pr->deletePageRule('023e105f4ecef8ad9ca31a8372d0c353', '9a7806061c88ada191ed06f989cc3dac');

        $this->assertTrue($result);
    }
}
