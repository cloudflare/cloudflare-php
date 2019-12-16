<?php


class MembershipTest extends TestCase
{
    public function testListMemberships()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listMemberships.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('memberships'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'account.name' => 'Demo Account',
                    'status' => 'accepted',
                    'order' => 'status',
                    'direction' => 'desc',
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\Membership($mock);
        $result = $zones->listMemberships('Demo Account', 'accepted', 1, 20, 'status', 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $zones->getBody()->result[0]->id);
    }

    public function testGetMembershipDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getMembershipDetails.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $membership = new \Cloudflare\API\Endpoints\Membership($mock);
        $details = $membership->getMembershipDetails('4536bcfad5faccb111b47003c79917fa');

        $this->assertObjectHasAttribute('id', $details);
        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $details->id);
        $this->assertObjectHasAttribute('code', $details);
        $this->assertEquals('05dd05cce12bbed97c0d87cd78e89bc2fd41a6cee72f27f6fc84af2e45c0fac0', $details->code);
        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $membership->getBody()->result->id);
    }

    public function testUpdateMembershipDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateMembershipStatus.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('memberships/4536bcfad5faccb111b47003c79917fa'),
                $this->equalTo([
                    'status' => 'accepted'
                ])
            );

        $membership = new \Cloudflare\API\Endpoints\Membership($mock);
        $membership->updateMembershipStatus('4536bcfad5faccb111b47003c79917fa', 'accepted');
        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $membership->getBody()->result->id);
    }

    public function testDeleteMembership()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteMembership.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('memberships/4536bcfad5faccb111b47003c79917fa'));

        $membership = new \Cloudflare\API\Endpoints\Membership($mock);

        $membership->deleteMembership('4536bcfad5faccb111b47003c79917fa');

        $this->assertEquals('4536bcfad5faccb111b47003c79917fa', $membership->getBody()->result->id);
    }
}
