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
}
