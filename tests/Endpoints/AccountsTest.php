<?php

use Cloudflare\API\Endpoints\Accounts;

/**
 * User: kanasite
 * Date: 01/28/2019
 * Time: 10:00
 */
class AccountsTest extends TestCase
{
    public function testListZones()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listAccounts.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'direction' => 'desc',
                ])
            );

        $accounts = new Accounts($mock);
        $result = $accounts->listAccounts(1, 20, 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $accounts->getBody()->result[0]->id);
    }

    public function testAddAccountWithDefaultType()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createStandardAccount.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts'),
                $this->equalTo([
                    'name' => 'Foo Bar',
                    'type' => 'standard',
                ])
            );

        $accounts = new Accounts($mock);

        $accounts->addAccount('Foo Bar');
        $this->assertEquals('2bab6ace8c72ed3f09b9eca6db1396bb', $accounts->getBody()->result->id);
    }

    public function testAddAccountWithCustomType()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createEnterpriseAccount.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts'),
                $this->equalTo([
                    'name' => 'Foo Bar',
                    'type' => 'enterprise',
                ])
            );

        $accounts = new Accounts($mock);

        $accounts->addAccount('Foo Bar', 'enterprise');
        $this->assertEquals('2bab6ace8c72ed3f09b9eca6db1396bb', $accounts->getBody()->result->id);
    }
}
