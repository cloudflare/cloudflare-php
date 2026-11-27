<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Lists;

class ListsTest extends TestCase
{
    private const ACCOUNT_ID = '023e105f4ecef8ad9ca31a8372d0c353';

    private const LIST_ID = '2c0fc9fa937b11eaa1b71c4d701ab86e';

    private const LISTS_PATH = 'accounts/023e105f4ecef8ad9ca31a8372d0c353/rules/lists';

    private const LIST_PATH = self::LISTS_PATH . '/2c0fc9fa937b11eaa1b71c4d701ab86e';

    private const ITEMS_PATH = self::LIST_PATH . '/items';

    public function testListLists()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/listLists.json');
        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo(self::LISTS_PATH));

        $lists = new Lists($mock);
        $result = $lists->listLists(self::ACCOUNT_ID);

        $this->assertEquals(self::LIST_ID, $result[0]->id);
        $this->assertEquals('list1', $result[0]->name);
        $this->assertEquals(10, $result[0]->num_items);
        $this->assertEquals(self::LIST_ID, $lists->getBody()->result[0]->id);
    }

    public function testGetListDetails()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/getListDetails.json');
        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo(self::LIST_PATH));

        $lists = new Lists($mock);
        $result = $lists->getListDetails(self::ACCOUNT_ID, self::LIST_ID);

        $this->assertEquals(self::LIST_ID, $result->id);
        $this->assertEquals('ip', $result->kind);
        $this->assertEquals(self::LIST_ID, $lists->getBody()->result->id);
    }

    public function testCreateList()
    {
        $mock = $this->mockAdapter('post', 'Endpoints/createList.json');
        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(self::LISTS_PATH),
                $this->equalTo([
                    'kind' => 'ip',
                    'name' => 'list1',
                    'description' => 'This is a note',
                ])
            );

        $lists = new Lists($mock);
        $result = $lists->createList(self::ACCOUNT_ID, 'ip', 'list1', 'This is a note');

        $this->assertEquals(self::LIST_ID, $result->id);
        $this->assertEquals(self::LIST_ID, $lists->getBody()->result->id);
    }

    public function testCreateListWithoutDescription()
    {
        $mock = $this->mockAdapter('post', 'Endpoints/createList.json');
        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(self::LISTS_PATH),
                $this->equalTo([
                    'kind' => 'ip',
                    'name' => 'list1',
                ])
            );

        $lists = new Lists($mock);
        $lists->createList(self::ACCOUNT_ID, 'ip', 'list1');
    }

    public function testUpdateListDescription()
    {
        $mock = $this->mockAdapter('put', 'Endpoints/updateListDescription.json');
        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo(self::LIST_PATH),
                $this->equalTo(['description' => 'Updated note'])
            );

        $lists = new Lists($mock);
        $result = $lists->updateListDescription(self::ACCOUNT_ID, self::LIST_ID, 'Updated note');

        $this->assertEquals('Updated note', $result->description);
        $this->assertEquals(self::LIST_ID, $lists->getBody()->result->id);
    }

    public function testDeleteList()
    {
        $mock = $this->mockAdapter('delete', 'Endpoints/deleteList.json');
        $mock->expects($this->once())
            ->method('delete')
            ->with($this->equalTo(self::LIST_PATH));

        $lists = new Lists($mock);

        $this->assertTrue($lists->deleteList(self::ACCOUNT_ID, self::LIST_ID));
        $this->assertEquals(self::LIST_ID, $lists->getBody()->result->id);
    }

    public function testListListItems()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/listListItems.json');
        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(self::ITEMS_PATH),
                $this->equalTo([
                    'search' => '10.0.0',
                    'per_page' => 100,
                    'cursor' => 'xxx',
                ])
            );

        $lists = new Lists($mock);
        $result = $lists->listListItems(self::ACCOUNT_ID, self::LIST_ID, '10.0.0', 100, 'xxx');

        $this->assertObjectHasProperty('result', $result);
        $this->assertObjectHasProperty('result_info', $result);
        $this->assertEquals('10.0.0.1', $result->result[0]->ip);
        $this->assertEquals('yyy', $result->result_info->cursors->after);
        $this->assertEquals('34b12448945f11eaa1b71c4d701ab86e', $lists->getBody()->result[0]->id);
    }

    public function testListListItemsWithoutFilters()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/listListItems.json');
        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(self::ITEMS_PATH),
                $this->equalTo([])
            );

        $lists = new Lists($mock);
        $lists->listListItems(self::ACCOUNT_ID, self::LIST_ID);
    }

    public function testGetListItem()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/getListItem.json');
        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo(self::ITEMS_PATH . '/34b12448945f11eaa1b71c4d701ab86e'));

        $lists = new Lists($mock);
        $result = $lists->getListItem(self::ACCOUNT_ID, self::LIST_ID, '34b12448945f11eaa1b71c4d701ab86e');

        $this->assertEquals('10.0.0.1', $result->ip);
        $this->assertEquals('34b12448945f11eaa1b71c4d701ab86e', $lists->getBody()->result->id);
    }

    public function testCreateListItems()
    {
        $items = [
            ['ip' => '10.0.0.1', 'comment' => 'Private IP address'],
            ['ip' => '10.0.0.0/24'],
        ];

        $mock = $this->mockAdapter('post', 'Endpoints/listItemsOperation.json');
        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo(self::ITEMS_PATH),
                $this->equalTo($items)
            );

        $lists = new Lists($mock);
        $operationId = $lists->createListItems(self::ACCOUNT_ID, self::LIST_ID, $items);

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $operationId);
        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $lists->getBody()->result->operation_id);
    }

    public function testReplaceListItems()
    {
        $items = [
            ['ip' => '10.0.0.1'],
            ['ip' => '2001:db8::/32', 'comment' => 'Documentation range'],
        ];

        $mock = $this->mockAdapter('put', 'Endpoints/listItemsOperation.json');
        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo(self::ITEMS_PATH),
                $this->equalTo($items)
            );

        $lists = new Lists($mock);
        $operationId = $lists->replaceListItems(self::ACCOUNT_ID, self::LIST_ID, $items);

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $operationId);
    }

    public function testDeleteListItems()
    {
        $mock = $this->mockAdapter('delete', 'Endpoints/listItemsOperation.json');
        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo(self::ITEMS_PATH),
                $this->equalTo([
                    'items' => [
                        ['id' => '34b12448945f11eaa1b71c4d701ab86e'],
                        ['id' => '6cbd5c0c945f11eaa1b71c4d701ab86e'],
                    ],
                ])
            );

        $lists = new Lists($mock);
        $operationId = $lists->deleteListItems(
            self::ACCOUNT_ID,
            self::LIST_ID,
            ['34b12448945f11eaa1b71c4d701ab86e', '6cbd5c0c945f11eaa1b71c4d701ab86e']
        );

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $operationId);
    }

    public function testGetBulkOperation()
    {
        $mock = $this->mockAdapter('get', 'Endpoints/getBulkOperation.json');
        $mock->expects($this->once())
            ->method('get')
            ->with($this->equalTo(self::LISTS_PATH . '/bulk_operations/4da8780eeb215e6cb7f48dd981c4ea02'));

        $lists = new Lists($mock);
        $result = $lists->getBulkOperation(self::ACCOUNT_ID, '4da8780eeb215e6cb7f48dd981c4ea02');

        $this->assertEquals('failed', $result->status);
        $this->assertEquals('This list is at the maximum number of items', $result->error);
        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $lists->getBody()->result->id);
    }

    private function mockAdapter(string $method, string $fixture)
    {
        $response = $this->getPsr7JsonResponseForFixture($fixture);

        $authMock = $this->createMock(\Cloudflare\API\Auth\Auth::class);
        $mock = $this->getMockBuilder(Adapter::class)
            ->setConstructorArgs([$authMock, 'https://example.com'])
            ->getMock();
        $mock->method($method)->willReturn($response);

        return $mock;
    }
}
