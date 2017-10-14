<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 15:31
 */
use \Helpers\Guzzle as Guzzle;
use PHPUnit_Framework_TestCase as TestBase;
class DNSTest extends TestBase
{
    public function testAddRecord()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/addRecord.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records'),
                $this->equalTo([]),
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
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/listRecords.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20,
                'match' => 'all',
                'type' => 'A',
                'name' => 'example.com',
                'content' => '127.0.0.1',
                'order' => 'type',
                'direction' => 'desc']),
              $this->equalTo([])
            );

        $zones = new \Cloudflare\API\Endpoints\DNS($mock);
        $result = $zones->listRecords("023e105f4ecef8ad9ca31a8372d0c353", "A", "example.com", "127.0.0.1", 1, 20, "type", "desc", "all");

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
    }

    public function testGetDNSRecordDetails()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/getDNSRecordDetails.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([])
            );

        $dns = new \Cloudflare\API\Endpoints\DNS($mock);
        $result = $dns->getRecordDetails("023e105f4ecef8ad9ca31a8372d0c353", "372e67954025e0ba6aaa6d586b9e0b59");

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->id);
    }

    public function testUpdateDNSRecord()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/updateDNSRecord.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $details = [
            'type' => 'A',
            'name' => "example.com",
            'content' => "1.2.3.4",
            'ttl' => 120,
            'proxied' => false,
        ];

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/dns_records/372e67954025e0ba6aaa6d586b9e0b59'),
                $this->equalTo([]),
                $this->equalTo($details)
            );

        $dns = new \Cloudflare\API\Endpoints\DNS($mock);
        $result = $dns->updateRecordDetails("023e105f4ecef8ad9ca31a8372d0c353", "372e67954025e0ba6aaa6d586b9e0b59", $details);

        $this->assertEquals("372e67954025e0ba6aaa6d586b9e0b59", $result->result->id);

        foreach ($details as $property => $value) {
            $this->assertEquals($result->result->{ $property }, $value);
        }
    }
}
