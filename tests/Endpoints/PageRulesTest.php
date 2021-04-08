<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 19:25
 */

namespace Cloudflare\API\Test\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\PageRulesActions;
use Cloudflare\API\Configurations\PageRulesTargets;
use Cloudflare\API\Endpoints\PageRules;
use Cloudflare\API\Test\TestCase;

class PageRulesTest extends TestCase
{
    public function testCreatePageRule()
    {
        $target = new PageRulesTargets('*example.com/images/*');
        $action = new PageRulesActions();
        $action->setAlwaysOnline(true);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createPageRule.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules'),
                $this->equalTo([
                    'targets' => $target->getArray(),
                    'actions' => $action->getArray(),
                    'status' => 'active',
                    'priority' => 1
                ])
            );

        $pageRules = new PageRules($mock);
        $result = $pageRules->createPageRule('023e105f4ecef8ad9ca31a8372d0c353', $target, $action, true, 1);

        $this->assertTrue($result);
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $pageRules->getBody()->result->id);
    }

    public function testListPageRules()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listPageRules.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules'),
                $this->equalTo([
                'status' => 'active',
                'order' => 'status',
                'direction' => 'desc',
                'match' => 'all'
              ])
            );

        $pageRules = new PageRules($mock);
        $pageRules->listPageRules('023e105f4ecef8ad9ca31a8372d0c353', 'active', 'status', 'desc', 'all');
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $pageRules->getBody()->result[0]->id);
    }

    public function testGetPageRuleDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPageRuleDetails.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules/9a7806061c88ada191ed06f989cc3dac')
            );

        $pageRules = new PageRules($mock);
        $pageRules->getPageRuleDetails('023e105f4ecef8ad9ca31a8372d0c353', '9a7806061c88ada191ed06f989cc3dac');
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $pageRules->getBody()->result->id);
    }

    public function testUpdatePageRule()
    {
        $target = new PageRulesTargets('*example.com/images/*');
        $action = new PageRulesActions();
        $action->setAlwaysOnline(true);

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updatePageRule.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules/9a7806061c88ada191ed06f989cc3dac'),
                $this->equalTo([
                    'targets' => $target->getArray(),
                    'actions' => $action->getArray(),
                    'status' => 'active',
                    'priority' => 1
                ])
            );

        $pageRules = new PageRules($mock);
        $result = $pageRules->updatePageRule('023e105f4ecef8ad9ca31a8372d0c353', '9a7806061c88ada191ed06f989cc3dac', $target, $action, true, 1);

        $this->assertTrue($result);
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $pageRules->getBody()->result->id);
    }

    public function testDeletePageRule()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deletePageRule.json');

        $mock = $this->createMock(Adapter::class);
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/pagerules/9a7806061c88ada191ed06f989cc3dac')
            );

        $pageRules = new PageRules($mock);
        $result = $pageRules->deletePageRule('023e105f4ecef8ad9ca31a8372d0c353', '9a7806061c88ada191ed06f989cc3dac');

        $this->assertTrue($result);
        $this->assertEquals('9a7806061c88ada191ed06f989cc3dac', $pageRules->getBody()->result->id);
    }
}
