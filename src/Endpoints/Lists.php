<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

/**
 * Account-level lists (IP, hostname, ASN and redirect) used in rule expressions.
 *
 * Item changes are asynchronous: they return an operation ID to pass to getBulkOperation().
 *
 * @link https://developers.cloudflare.com/api/resources/rules/subresources/lists/
 */
class Lists implements API
{
    use BodyAccessorTrait;

    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function listLists(string $accountId): array
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/rules/lists');
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function getListDetails(string $accountId, string $listId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/rules/lists/' . $listId);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    /**
     * @param string $kind One of ip, hostname, asn or redirect.
     */
    public function createList(string $accountId, string $kind, string $name, string $description = ''): \stdClass
    {
        $options = [
            'kind' => $kind,
            'name' => $name,
        ];

        if (!empty($description)) {
            $options['description'] = $description;
        }

        $response = $this->adapter->post('accounts/' . $accountId . '/rules/lists', $options);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function updateListDescription(string $accountId, string $listId, string $description): \stdClass
    {
        $response = $this->adapter->put(
            'accounts/' . $accountId . '/rules/lists/' . $listId,
            ['description' => $description]
        );
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function deleteList(string $accountId, string $listId): bool
    {
        $response = $this->adapter->delete('accounts/' . $accountId . '/rules/lists/' . $listId);
        $this->body = json_decode($response->getBody());

        return isset($this->body->result->id);
    }

    /**
     * Returns one page of items. Pass result_info->cursors->after as $cursor to fetch the next page.
     */
    public function listListItems(
        string $accountId,
        string $listId,
        string $search = '',
        int $perPage = 0,
        string $cursor = ''
    ): \stdClass {
        $query = [];

        if (!empty($search)) {
            $query['search'] = $search;
        }

        if ($perPage > 0) {
            $query['per_page'] = $perPage;
        }

        if (!empty($cursor)) {
            $query['cursor'] = $cursor;
        }

        $response = $this->adapter->get('accounts/' . $accountId . '/rules/lists/' . $listId . '/items', $query);
        $this->body = json_decode($response->getBody());

        return (object)[
            'result' => $this->body->result,
            'result_info' => $this->body->result_info ?? null,
        ];
    }

    public function getListItem(string $accountId, string $listId, string $itemId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/rules/lists/' . $listId . '/items/' . $itemId);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    /**
     * Appends items to the list.
     *
     * @param array $items Items for the list's kind, e.g. [['ip' => '192.0.2.1', 'comment' => 'optional']].
     * @return string The bulk operation ID.
     */
    public function createListItems(string $accountId, string $listId, array $items): string
    {
        $response = $this->adapter->post('accounts/' . $accountId . '/rules/lists/' . $listId . '/items', $items);
        $this->body = json_decode($response->getBody());

        return $this->body->result->operation_id;
    }

    /**
     * Removes every item in the list and adds the given items.
     *
     * @param array $items Items for the list's kind, e.g. [['ip' => '192.0.2.1', 'comment' => 'optional']].
     * @return string The bulk operation ID.
     */
    public function replaceListItems(string $accountId, string $listId, array $items): string
    {
        $response = $this->adapter->put('accounts/' . $accountId . '/rules/lists/' . $listId . '/items', $items);
        $this->body = json_decode($response->getBody());

        return $this->body->result->operation_id;
    }

    /**
     * @param string[] $itemIds IDs of the items to remove.
     * @return string The bulk operation ID.
     */
    public function deleteListItems(string $accountId, string $listId, array $itemIds): string
    {
        $items = array_map(function (string $itemId) {
            return ['id' => $itemId];
        }, array_values($itemIds));

        $response = $this->adapter->delete(
            'accounts/' . $accountId . '/rules/lists/' . $listId . '/items',
            ['items' => $items]
        );
        $this->body = json_decode($response->getBody());

        return $this->body->result->operation_id;
    }

    /**
     * Returns the operation with its status: pending, running, completed or failed (with an error message).
     */
    public function getBulkOperation(string $accountId, string $operationId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/rules/lists/bulk_operations/' . $operationId);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }
}
