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
}