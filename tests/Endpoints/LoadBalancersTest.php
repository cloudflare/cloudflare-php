<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\LoadBalancer;
use Cloudflare\API\Endpoints\LoadBalancers;

/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

class LoadBalancersTest extends TestCase
{
    public function testCreateLoadBalancer()
    {
        $pools = [
            '17b5962d775c646f3f9725cbc7a53df4',
            '9290f38c5d07c2e2f4df57b1f61d4196',
            '00920f38ce07c2e2f4df50b1f61d4194'
        ];

        $lbConfiguration = new LoadBalancer('www.example.com', $pools, '17b5962d775c646f3f9725cbc7a53df4');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createLoadBalancer.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/699d98642c564d2e855e9661899b7252/load_balancers'),
                $lbConfiguration->getArray()
            );

        $loadBalancers = new LoadBalancers($mock);
        $result = $loadBalancers->createLoadBalancer('699d98642c564d2e855e9661899b7252', $lbConfiguration);

        $this->assertTrue($result);
        $this->assertEquals('699d98642c564d2e855e9661899b7252', $loadBalancers->getBody()->result->id);
    }

    public function testListLoadBalancer()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listLoadBalancers.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/699d98642c564d2e855e9661899b7252/load_balancers')
            );

        $loadBalancers = new LoadBalancers($mock);
        $loadBalancers->listLoadBalancers('699d98642c564d2e855e9661899b7252');
        $this->assertEquals('699d98642c564d2e855e9661899b7252', $loadBalancers->getBody()->result[0]->id);
    }

    public function testGetLoadBalancerDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getLoadBalancerDetails.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/699d98642c564d2e855e9661899b7252/load_balancers/699d98642c564d2e855e9661899b7252')
            );

        $loadBalancers = new LoadBalancers($mock);
        $loadBalancers->getLoadBalancerDetails('699d98642c564d2e855e9661899b7252', '699d98642c564d2e855e9661899b7252');
        $this->assertEquals('699d98642c564d2e855e9661899b7252', $loadBalancers->getBody()->result->id);
    }

    public function testUpdateLoadBalancer()
    {
        $pools = [
            '17b5962d775c646f3f9725cbc7a53df4',
            '9290f38c5d07c2e2f4df57b1f61d4196',
            '00920f38ce07c2e2f4df50b1f61d4194'
        ];

        $lbConfiguration = new LoadBalancer('www.example.com', $pools, '17b5962d775c646f3f9725cbc7a53df4');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateLoadBalancer.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/699d98642c564d2e855e9661899b7252/load_balancers/699d98642c564d2e855e9661899b7252'),
                $this->equalTo($lbConfiguration->getArray())
            );

        $loadBalancers = new LoadBalancers($mock);
        $result = $loadBalancers->updateLoadBalancer('699d98642c564d2e855e9661899b7252', '699d98642c564d2e855e9661899b7252', $lbConfiguration);

        $this->assertTrue($result);
        $this->assertEquals('699d98642c564d2e855e9661899b7252', $loadBalancers->getBody()->result->id);
    }

    public function testDeleteLoadBalancer()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteLoadBalancer.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/699d98642c564d2e855e9661899b7252/load_balancers/699d98642c564d2e855e9661899b7252')
            );

        $loadBalancers = new LoadBalancers($mock);
        $result = $loadBalancers->deleteLoadBalancer('699d98642c564d2e855e9661899b7252', '699d98642c564d2e855e9661899b7252');

        $this->assertTrue($result);
        $this->assertEquals('699d98642c564d2e855e9661899b7252', $loadBalancers->getBody()->result->id);
    }
}
