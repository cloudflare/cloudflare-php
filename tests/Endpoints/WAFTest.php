<?php
use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\WAF;

class WAFTest extends TestCase
{   
    public function testGetWAFSetting(){
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getWAFSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $waf = new WAF($mock);
        $result = $waf->getWAFSetting('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertSame('off', $result);
    }
    
    public function testGetPackages()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listPackages.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'match' => 'all',
                    'order' => 'status',
                    'direction' => 'desc'
                ])
            );

        $waf = new WAF($mock);
        $result = $waf->getPackages('023e105f4ecef8ad9ca31a8372d0c353', 1, 20, 'status', 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('a25a9a7e9c00afc1fb2e0245519d725b', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('a25a9a7e9c00afc1fb2e0245519d725b', $waf->getBody()->result[0]->id);
    }

    public function testGetPackageInfo()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPackageInfo.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b')
            );

        $waf = new WAF($mock);
        $result = $waf->getPackageInfo('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b');

        $this->assertEquals('a25a9a7e9c00afc1fb2e0245519d725b', $result->id);
        $this->assertEquals('a25a9a7e9c00afc1fb2e0245519d725b', $waf->getBody()->result->id);
    }

    public function testGetRules()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listPackageRules.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/rules'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'match' => 'all',
                    'order' => 'status',
                    'direction' => 'desc'
                ])
            );

        $waf = new WAF($mock);
        $result = $waf->getRules('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 1, 20, 'status', 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('92f17202ed8bd63d69a66b86a49a8f6b', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('92f17202ed8bd63d69a66b86a49a8f6b', $waf->getBody()->result[0]->id);
    }

    public function testGetRuleInfo()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPackageRuleInfo.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/rules/f939de3be84e66e757adcdcb87908023')
            );

        $waf = new WAF($mock);
        $result = $waf->getRuleInfo('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 'f939de3be84e66e757adcdcb87908023');

        $this->assertEquals('f939de3be84e66e757adcdcb87908023', $result->id);
        $this->assertEquals('f939de3be84e66e757adcdcb87908023', $waf->getBody()->result->id);
    }
    
    public function testUpdateWAFSetting()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateWAFSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/waf'),
                $this->equalTo(['value' => 'off'])
            );

        $wafMock = new WAF($mock);
        $result = $wafMock->updateWAFSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'off');

        $this->assertTrue($result);
    }

    public function testUpdateRule()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePackageRule.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $details = [
            'mode' => 'on',
        ];

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/rules/f939de3be84e66e757adcdcb87908023'),
                $this->equalTo($details)
            );

        $waf = new WAF($mock);
        $result = $waf->updateRule('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 'f939de3be84e66e757adcdcb87908023', 'on');

        $this->assertEquals('f939de3be84e66e757adcdcb87908023', $result->id);

        foreach ($details as $property => $value) {
            $this->assertEquals($result->{ $property }, $value);
        }
        $this->assertEquals('f939de3be84e66e757adcdcb87908023', $waf->getBody()->result->id);
    }

    public function testGetGroups()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listPackageGroups.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/groups'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'match' => 'all',
                    'order' => 'status',
                    'direction' => 'desc'
                ])
            );

        $waf = new WAF($mock);
        $result = $waf->getGroups('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 1, 20, 'status', 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $waf->getBody()->result[0]->id);
    }

    public function testGetGroupInfo()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPackageGroupInfo.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/groups/de677e5818985db1285d0e80225f06e5')
            );

        $waf = new WAF($mock);
        $result = $waf->getGroupInfo('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 'de677e5818985db1285d0e80225f06e5');

        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $result->id);
        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $waf->getBody()->result->id);
    }

    public function testUpdateGroup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePackageGroup.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $details = [
            'mode' => 'off',
        ];

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/waf/packages/a25a9a7e9c00afc1fb2e0245519d725b/groups/de677e5818985db1285d0e80225f06e5'),
                $this->equalTo($details)
            );

        $waf = new WAF($mock);
        $result = $waf->updateGroup('023e105f4ecef8ad9ca31a8372d0c353', 'a25a9a7e9c00afc1fb2e0245519d725b', 'de677e5818985db1285d0e80225f06e5', 'off');

        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $result->id);

        foreach ($details as $property => $value) {
            $this->assertEquals($result->{ $property }, $value);
        }
        $this->assertEquals('de677e5818985db1285d0e80225f06e5', $waf->getBody()->result->id);
    }
}
