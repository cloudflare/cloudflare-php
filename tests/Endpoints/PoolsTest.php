<?php

namespace Cloudflare\API\Test\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\Pool;
use Cloudflare\API\Endpoints\Pools;
use Cloudflare\API\Test\TestCase;

/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

class PoolsTest extends TestCase
{
    public function testCreatePool()
    {
        $origins = [
            [
                'name' => 'app-server-1',
                'address' => '0.0.0.0',
                'enabled' => true,
                'weight' => 0.56
            ]
        ];

        $poolConfiguration = new Pool('primary-dc-1', $origins);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createPool.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/load_balancers/pools'),
                $poolConfiguration->getArray()
            );

        $pools = new Pools($mock);
        $result = $pools->createPool('01a7362d577a6c3019a474fd6f485823', $poolConfiguration);

        $this->assertTrue($result);
        $this->assertEquals('17b5962d775c646f3f9725cbc7a53df4', $pools->getBody()->result->id);
    }

    public function testListPools()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listPools.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/load_balancers/pools')
            );

        $pools = new Pools($mock);
        $pools->listPools('01a7362d577a6c3019a474fd6f485823');
        $this->assertEquals('17b5962d775c646f3f9725cbc7a53df4', $pools->getBody()->result[0]->id);
    }

    public function testGetPoolDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPoolDetails.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/load_balancers/pools/17b5962d775c646f3f9725cbc7a53df4')
            );

        $pools = new Pools($mock);
        $pools->getPoolDetails('01a7362d577a6c3019a474fd6f485823', '17b5962d775c646f3f9725cbc7a53df4');
        $this->assertEquals('17b5962d775c646f3f9725cbc7a53df4', $pools->getBody()->result->id);
    }

    public function testUpdatePool()
    {
        $origins = [
            [
                'name' => 'app-server-1',
                'address' => '0.0.0.0',
                'enabled' => true,
                'weight' => 0.56
            ]
        ];

        $poolConfiguration = new Pool('primary-dc-1', $origins);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePool.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/load_balancers/pools/17b5962d775c646f3f9725cbc7a53df4'),
                $this->equalTo($poolConfiguration->getArray())
            );

        $pools = new Pools($mock);
        $result = $pools->updatePool('01a7362d577a6c3019a474fd6f485823', '17b5962d775c646f3f9725cbc7a53df4', $poolConfiguration);

        $this->assertTrue($result);
        $this->assertEquals('17b5962d775c646f3f9725cbc7a53df4', $pools->getBody()->result->id);
    }

    public function testDeletePool()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deletePool.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/load_balancers/pools/17b5962d775c646f3f9725cbc7a53df4')
            );

        $pools = new Pools($mock);
        $result = $pools->deletePool('01a7362d577a6c3019a474fd6f485823', '17b5962d775c646f3f9725cbc7a53df4');

        $this->assertTrue($result);
        $this->assertEquals('17b5962d775c646f3f9725cbc7a53df4', $pools->getBody()->result->id);
    }
}
