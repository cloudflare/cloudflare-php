<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\UserInvites;

class UserInviteTest extends TestCase
{
    public function testUpdateUserInvite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/respondToUserInvite.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('user/invites/4f5f0c14a2a41d5063dd301b2f829f04'),
                $this->equalTo([
                    'status' => 'accepted',
                ])
            );

        $userInvites = new UserInvites($mock);

        $result = $userInvites->respondToInvite('4f5f0c14a2a41d5063dd301b2f829f04', 'accepted');

        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('4f5f0c14a2a41d5063dd301b2f829f04', $userInvites->getBody()->result->id);
    }
}
