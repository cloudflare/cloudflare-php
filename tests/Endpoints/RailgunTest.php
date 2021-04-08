<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 23/10/2017
 * Time: 11:20
 */

namespace Cloudflare\API\Test\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Railgun;
use Cloudflare\API\Test\TestCase;

class RailgunTest extends TestCase
{
    public function testCreate()
    {
        $details = [
            'name' => 'My Railgun',
        ];

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createRailgun.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('railguns'),
                $this->equalTo(['name' => $details['name']])
            );

        $railgun = new Railgun($mock);
        $result = $railgun->create($details['name']);

        $this->assertObjectHasAttribute('result', $result);

        foreach ($details as $property => $value) {
            $this->assertEquals($result->result->{ $property }, $value);
        }
        $this->assertEquals('e928d310693a83094309acf9ead50448', $railgun->getBody()->result->id);
    }

    public function testlist()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listRailguns.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'direction' => 'desc'
                ])
            );

        $railgun = new Railgun($mock);
        $result = $railgun->list(1, 20, 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);
        $this->assertEquals('e928d310693a83094309acf9ead50448', $railgun->getBody()->result[0]->id);
    }

    public function testget()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getRailgun.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448')
            );

        $railgun = new Railgun($mock);
        $result = $railgun->get('e928d310693a83094309acf9ead50448');

        $this->assertEquals('e928d310693a83094309acf9ead50448', $result->id);
        $this->assertEquals('e928d310693a83094309acf9ead50448', $railgun->getBody()->result->id);
    }

    public function testgetZones()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listRailgunZones.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448/zones')
            );

        $railgun = new Railgun($mock);
        $result = $railgun->getZones('e928d310693a83094309acf9ead50448');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $railgun->getBody()->result[0]->id);
    }

    public function testupdate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateRailgun.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('patch')->willReturn($response);

        $details = [
            'enabled' => true,
        ];

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448'),
                $this->equalTo($details)
            );

        $waf = new Railgun($mock);
        $result = $waf->update('e928d310693a83094309acf9ead50448', true);

        $this->assertEquals('e928d310693a83094309acf9ead50448', $result->id);
        $this->assertEquals('e928d310693a83094309acf9ead50448', $waf->getBody()->result->id);
    }

    public function testdelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteRailgun.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448')
            );

        $waf = new Railgun($mock);
        $waf->delete('e928d310693a83094309acf9ead50448');
        $this->assertEquals('e928d310693a83094309acf9ead50448', $waf->getBody()->result->id);
    }
}
