<?php

class WorkersKVTest extends TestCase
{

    public function testCreateNamespace()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createWorkersKVNamespace.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/storage/kv/namespaces'),
                $this->equalTo(['title' => "Foo"])
            );

        $worker = new \Cloudflare\API\Endpoints\WorkersKV($mock);
        $result = $worker->createNamespace("023e105f4ecef8ad9ca31a8372d0c353", "Foo");
        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('6b23666a511e428aa9da1bad45a0c81f', $result->id);
    }

    public function testGetNamespaces()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWorkersKVNamespaces.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/storage/kv/namespaces')
            );

        $worker = new \Cloudflare\API\Endpoints\WorkersKV($mock);
        $result = $worker->getNameSpaces("023e105f4ecef8ad9ca31a8372d0c353");
        $this->assertCount(1, $result);
    }

    public function testListNamespaceKeys()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWorkersKVListOfNamespaces.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/storage/kv/namespaces'),
                $this->equalTo([
                    "page" => 1,
                    "per_page" => 100
                ]),
            );

        $worker = new \Cloudflare\API\Endpoints\WorkersKV($mock);
        $result = $worker->getListOfNamespaces("023e105f4ecef8ad9ca31a8372d0c353", 1, 100);
        $this->assertCount(1, $result);
    }

    public function testGetListOfNamespaces()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWorkersKVListNamespaceKeys.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/storage/kv/namespaces/0f2ac74b498b48028cb68387c421e279/keys')
            );

        $worker = new \Cloudflare\API\Endpoints\WorkersKV($mock);
        $result = $worker->listNamespaceKeys("023e105f4ecef8ad9ca31a8372d0c353", "0f2ac74b498b48028cb68387c421e279");
        $this->assertCount(1, $result);
    }

    public function testWriteMultipleKeyValuePairs()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/putWorkersKVWriteMultipleKeyValuePairs.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->method('put')->willReturn($response);

        $bulk_keys = [
            [
                "key" => "Foo", "value" => "bar"
            ],
            [
                "key" => "Foo2", "value" => "bar2"
            ]
        ];
        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/storage/kv/namespaces/0f2ac74b498b48028cb68387c421e279/bulk'),
                $this->equalTo(
                    $bulk_keys
                )
            );

        $worker = new \Cloudflare\API\Endpoints\WorkersKV($mock);
        $result = $worker->writeMultipleKeyValuePairs("023e105f4ecef8ad9ca31a8372d0c353", "0f2ac74b498b48028cb68387c421e279", $bulk_keys);
        $this->assertTrue($result);
    }
}
