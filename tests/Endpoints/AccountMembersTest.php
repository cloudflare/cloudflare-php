<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\AccountMembers;

class AccountMembersTest extends TestCase
{
    public function testAddAccountMember()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createAccountMember.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/members'),
                $this->equalTo([
                    'email' => 'user@example.com',
                    'roles' => [
                        '3536bcfad5faccb999b47003c79917fb',
                    ],
                ])
            );

        $accountMembers = new AccountMembers($mock);
        $accountMembers->addAccountMember('01a7362d577a6c3019a474fd6f485823', 'user@example.com', ['3536bcfad5faccb999b47003c79917fb']);

        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $accountMembers->getBody()->result->id);
    }

    public function testListAccountMembers()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listAccountMembers.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/members'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                ])
            );

        $accountMembers = new AccountMembers($mock);
        $result = $accountMembers->listAccountMembers('023e105f4ecef8ad9ca31a8372d0c353', 1, 20);

        $this->assertObjectHasAttribute('result', $result);

        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->count);
        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $accountMembers->getBody()->result[0]->id);
    }
}
