<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 15:14
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class DNS implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $zoneID
     * @param string $type
     * @param string $name
     * @param string $content
     * @param int $ttl
     * @param bool $proxied
     * @param string $priority
     * @param array $data
     * @return bool
     */
    public function addRecord(
        string $zoneID,
        string $type,
        string $name,
        string $content,
        int $ttl = 0,
        bool $proxied = true,
        string $priority = '',
        array $data = []
    ): bool {
        $options = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'proxied' => $proxied
        ];

        if ($ttl > 0) {
            $options['ttl'] = $ttl;
        }

        if (is_numeric($priority)) {
            $options['priority'] = (int)$priority;
        }
        
        if (!empty($data)) {
            $options['data'] = $data;
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/dns_records', $options);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function listRecords(
        string $zoneID,
        string $type = '',
        string $name = '',
        string $content = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = '',
        string $match = 'all'
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'match' => $match
        ];

        if (!empty($type)) {
            $query['type'] = $type;
        }

        if (!empty($name)) {
            $query['name'] = $name;
        }

        if (!empty($content)) {
            $query['content'] = $content;
        }

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('zones/' . $zoneID . '/dns_records', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getRecordDetails(string $zoneID, string $recordID): \stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneID . '/dns_records/' . $recordID);
        $this->body = json_decode($user->getBody());
        return $this->body->result;
    }

    public function getRecordID(string $zoneID, string $type = '', string $name = ''): string
    {
        $records = $this->listRecords($zoneID, $type, $name);
        if (isset($records->result[0]->id)) {
            return $records->result[0]->id;
        }
        return false;
    }

    public function updateRecordDetails(string $zoneID, string $recordID, array $details): \stdClass
    {
        $response = $this->adapter->put('zones/' . $zoneID . '/dns_records/' . $recordID, $details);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }

    public function deleteRecord(string $zoneID, string $recordID): bool
    {
        $user = $this->adapter->delete('zones/' . $zoneID . '/dns_records/' . $recordID);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
