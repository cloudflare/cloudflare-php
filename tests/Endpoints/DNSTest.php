<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 15:31
 */
class DNSTest extends PHPUnit_Framework_TestCase
{
    public function testAddRecord()
    {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "type": "A",
    "name": "example.com",
    "content": "1.2.3.4",
    "proxiable": true,
    "proxied": false,
    "ttl": 120,
    "locked": false,
    "zone_id": "023e105f4ecef8ad9ca31a8372d0c353",
    "zone_name": "example.com",
    "created_on": "2014-01-01T05:20:00.12345Z",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "data": {}
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records'), $this->equalTo([]),
                $this->equalTo([
                    'type' => 'A',
                    'name' => 'example.com',
                    'content' => '127.0.0.1',
                    'ttl' => 120,
                    'proxied' => false
                ])
            );

        $dns = new \Cloudflare\API\Endpoints\DNS($mock);
        $dns->addRecord('023e105f4ecef8ad9ca31a8372d0c353', 'A', 'example.com', '127.0.0.1', '120', false);
    }

    public function testListRecords()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": [
    {
      "id": "372e67954025e0ba6aaa6d586b9e0b59",
      "type": "A",
      "name": "example.com",
      "content": "1.2.3.4",
      "proxiable": true,
      "proxied": false,
      "ttl": 120,
      "locked": false,
      "zone_id": "023e105f4ecef8ad9ca31a8372d0c353",
      "zone_name": "example.com",
      "created_on": "2014-01-01T05:20:00.12345Z",
      "modified_on": "2014-01-01T05:20:00.12345Z",
      "data": {}
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
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records?page=1&per_page=20&match=all&type=A&name=example.com&content=127.0.0.1&order=type&direction=desc'),
                $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\DNS($mock);
        $result = $zones->listRecords("023e105f4ecef8ad9ca31a8372d0c353","A", "example.com", "127.0.0.1", 1, 20, "type", "desc", "all");

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
    }

    public function testGetRecordDetails()
    {
        $stream = GuzzleHttp\Psr7\stream_for('{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "372e67954025e0ba6aaa6d586b9e0b59",
    "type": "A",
    "name": "example.com",
    "content": "1.2.3.4",
    "proxiable": true,
    "proxied": false,
    "ttl": 120,
    "locked": false,
    "zone_id": "023e105f4ecef8ad9ca31a8372d0c353",
    "zone_name": "example.com",
    "created_on": "2014-01-01T05:20:00.12345Z",
    "modified_on": "2014-01-01T05:20:00.12345Z",
    "data": {}
  }
}');

        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([])
            );

        $dns = new \Cloudflare\API\Endpoints\DNS($mock);
        $result = $dns->getRecordDetails("023e105f4ecef8ad9ca31a8372d0c353", "372e67954025e0ba6aaa6d586b9e0b59");

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->id);
    }
}
