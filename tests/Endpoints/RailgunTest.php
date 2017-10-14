<?php
/**
* Created by Notepad++.
* User: MertOtrk
* Date: 14/10/2017
* Time: 09:32
*/

use \Helpers\Guzzle as Guzzle;
use PHPUnit_Framework_TestCase as TestBase;

class RailgunTest extends TestBase
{
    public function testcreate()
    {
        $details = [
        'name' => "My Railgun",
        ];
        
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/createRailgun.json');
        
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);
        
        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('railguns'),
              $this->equalTo([]),
                $this->equalTo(['name' => $details['name']])
            );
            
        $railgun = new \Cloudflare\API\Endpoints\Railgun($mock);
        $result = $railgun->create($details['name']);
    
        $this->assertObjectHasAttribute('result', $result);

        foreach ($details as $property => $value) {
            $this->assertEquals($result->result->{ $property }, $value);
        }
    }

    public function testlist()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/listRailguns.json');
        
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);
        
        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns'),
              $this->equalTo([
                'page' => 1,
                'per_page' => 20,
                'direction' => 'desc'
              ]),
                $this->equalTo([])
            );
            
        $railgun = new \Cloudflare\API\Endpoints\Railgun($mock);
        $result = $railgun->list(1, 20, "desc");

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);
    }
    
    public function testget()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/getRailgun.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448'),
                $this->equalTo([])
            );

        $railgun = new \Cloudflare\API\Endpoints\Railgun($mock);
        $result = $railgun->get("e928d310693a83094309acf9ead50448");

        $this->assertEquals("e928d310693a83094309acf9ead50448", $result->id);
    }
    
    public function testgetZones()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/listRailgunZones.json');
        
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);
        
        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448/zones'),
              $this->equalTo([]),
                $this->equalTo([])
            );
            
        $railgun = new \Cloudflare\API\Endpoints\Railgun($mock);
        $result = $railgun->getZones("e928d310693a83094309acf9ead50448");

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);
    }
    
    public function testupdate()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/updateRailgun.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $details = [
            'enabled' => true,
        ];

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448'),
                $this->equalTo([]),
                $this->equalTo($details)
            );

        $waf = new \Cloudflare\API\Endpoints\Railgun($mock);
        $result = $waf->update("e928d310693a83094309acf9ead50448", true);

        $this->assertEquals("e928d310693a83094309acf9ead50448", $result->id);
    }
    
    public function testdelete()
    {
        $response = (new Guzzle())->getPsr7JsonResponseForFixture('Endpoints/deleteRailgun.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('railguns/e928d310693a83094309acf9ead50448'),
                $this->equalTo([]),
                $this->equalTo([])
            );

        $waf = new \Cloudflare\API\Endpoints\Railgun($mock);
        $waf->delete("e928d310693a83094309acf9ead50448");
    }
}
