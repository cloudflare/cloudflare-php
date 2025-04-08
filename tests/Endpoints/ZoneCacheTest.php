<?php

class ZoneCacheTest extends TestCase
{
    public function testCachePurgeEverything()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeEverything.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo(['purge_everything' => true])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurgeEverything('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeHost()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeHost.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo(
                    [
                        'files' => [],
                        'tags' => [],
                        'hosts' => ['dash.cloudflare.com']
                    ]
                )
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [], [], ['dash.cloudflare.com']);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurge()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurge.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo([
                    'files' => [
                        'https://example.com/file.jpg',
                    ]
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [
            'https://example.com/file.jpg',
        ]);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeIncludingEnvironments()
    {
        $envResp = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironments.json');
        $cacheResp = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurge.json');
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->expects($this->once())
            ->method('get')
            ->willReturn($envResp)
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments')
            );

        $mock->expects($this->exactly(4))
            ->method('post')
            ->willReturn($cacheResp)
            ->withConsecutive(
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/first/purge_cache'),
                    $this->equalTo([
                        'files' => [
                            'https://example.com/file.jpg',
                        ]
                    ])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/second/purge_cache'),
                    $this->equalTo([
                        'files' => [
                            'https://example.com/file.jpg',
                        ]
                    ])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/third/purge_cache'),
                    $this->equalTo([
                        'files' => [
                            'https://example.com/file.jpg',
                        ]
                    ])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                    $this->equalTo([
                        'files' => [
                            'https://example.com/file.jpg',
                        ]
                    ])
                ]
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [
            'https://example.com/file.jpg',
        ], null, null, true);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeEverythingIncludingEnvironments()
    {
        $envResp = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironments.json');
        $cacheResp = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeEverything.json');
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();

        $mock->expects($this->once())
            ->method('get')
            ->willReturn($envResp)
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments')
            );

        $mock->expects($this->exactly(4))
            ->method('post')
            ->willReturn($cacheResp)
            ->withConsecutive(
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/first/purge_cache'),
                    $this->equalTo(['purge_everything' => true])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/second/purge_cache'),
                    $this->equalTo(['purge_everything' => true])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/third/purge_cache'),
                    $this->equalTo(['purge_everything' => true])
                ],
                [
                    $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                    $this->equalTo(['purge_everything' => true])
                ]
            );

        $zones = new \Cloudflare\API\Endpoints\Zones($mock);
        $result = $zones->cachePurgeEverything('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }
}
