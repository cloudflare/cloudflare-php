<?php

class FirewallTest extends TestCase
{
    public function testCreatePageRules()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createFirewallRules.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/rules'),
                $this->equalTo([
                    [
                        'action' => 'block',
                        'description' => 'Foo',
                        'filter' => [
                            'expression' => 'http.cookie eq "foo"',
                            'paused' => false
                        ],
                    ],
                    [
                        'action' => 'block',
                        'description' => 'Bar',
                        'filter' => [
                            'expression' => 'http.cookie eq "bar"',
                            'paused' => false
                        ],
                    ]
                ])
            );

        $firewall = new Cloudflare\API\Endpoints\Firewall($mock);
        $result = $firewall->createFirewallRules(
            '023e105f4ecef8ad9ca31a8372d0c353',
            [
                [
                    'filter' => [
                        'expression' => 'http.cookie eq "foo"',
                        'paused' => false
                    ],
                    'action' => 'block',
                    'description' => 'Foo'
                ],
                [
                    'filter' => [
                        'expression' => 'http.cookie eq "bar"',
                        'paused' => false
                    ],
                    'action' => 'block',
                    'description' => 'Bar'
                ],
            ]
        );
        $this->assertTrue($result);
    }

    public function testCreatePageRule()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createFirewallRule.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/rules'),
                $this->equalTo([
                    [
                        'action' => 'block',
                        'description' => 'Foobar',
                        'filter' => [
                            'expression' => 'http.cookie eq "foobar"',
                            'paused' => false
                        ],
                        'paused' => false
                    ]
                ])
            );

        $firewall = new Cloudflare\API\Endpoints\Firewall($mock);
        $options = new \Cloudflare\API\Configurations\FirewallRuleOptions();
        $options->setActionBlock();
        $result = $firewall->createFirewallRule(
            '023e105f4ecef8ad9ca31a8372d0c353',
            'http.cookie eq "foobar"',
            $options,
            'Foobar'
        );
        $this->assertTrue($result);
    }

    public function testListFirewallRules()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listFirewallRules.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/rules'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 50
                ])
            );

        $firewall = new Cloudflare\API\Endpoints\Firewall($mock);
        $result = $firewall->listFirewallRules('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('970b10321e3f4adda674c912b5f76591', $result->result[0]->id);
    }

    public function testDeleteFirewallRule()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteFirewallRule.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/rules/970b10321e3f4adda674c912b5f76591')
            );

        $firewall = new Cloudflare\API\Endpoints\Firewall($mock);
        $firewall->deleteFirewallRule('023e105f4ecef8ad9ca31a8372d0c353', '970b10321e3f4adda674c912b5f76591');
    }

    public function testUpdateFirewallRule()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateFirewallRule.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/firewall/rules/970b10321e3f4adda674c912b5f76591'),
                $this->equalTo([
                    'id' => '970b10321e3f4adda674c912b5f76591',
                    'action' => 'block',
                    'description' => 'Foo',
                    'filter' => [
                        'id' => '5def9c4297e0466cb0736b838345d910',
                        'expression' => 'http.cookie eq "foo"',
                        'paused' => false
                    ],
                    'paused' => false
                ])
            );

        $firewall = new Cloudflare\API\Endpoints\Firewall($mock);
        $options = new \Cloudflare\API\Configurations\FirewallRuleOptions();
        $options->setActionBlock();
        $result = $firewall->updateFirewallRule(
            '023e105f4ecef8ad9ca31a8372d0c353',
            '970b10321e3f4adda674c912b5f76591',
            '5def9c4297e0466cb0736b838345d910',
            'http.cookie eq "foo"',
            $options,
            'Foo'
        );
        $this->assertEquals('970b10321e3f4adda674c912b5f76591', $result->id);
    }
}
