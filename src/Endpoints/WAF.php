<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 23/10/2017
 * Time: 11:17
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class WAF implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function getWAFSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/waf'
        );
        $body   = json_decode($return->getBody());

        if (isset($body->result)) {
            return $body->result->value;
        }

        return false;
    }

    public function getPackages(
        string $zoneID,
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

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }


    public function getPackageInfo(
        string $zoneID,
        string $packageID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/' . $packageID);
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }

    public function getRules(
        string $zoneID,
        string $packageID,
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

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/rules', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getRuleInfo(
        string $zoneID,
        string $packageID,
        string $ruleID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/rules/' . $ruleID);
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }
    
    public function updateWAFSetting(string $zoneID, string $value)
    {
        $waf = $this->adapter->patch('zones/' . $zoneID . '/settings/waf',
            ['value' => $value]
        );
        $body = json_decode($waf->getBody());

        if (isset($body->success)) {
            return $body->success;
        }

        return false;
    }

    public function updateRule(
        string $zoneID,
        string $packageID,
        string $ruleID,
        string $status
    ): \stdClass {
        $query = [
            'mode' => $status,
        ];

        $user = $this->adapter->patch(
            'zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/rules/' . $ruleID,
            $query
        );
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }

    public function getGroups(
        string $zoneID,
        string $packageID,
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

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get(
            'zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/groups',
            $query
        );
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getGroupInfo(
        string $zoneID,
        string $packageID,
        string $groupID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/groups/' . $groupID);
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }

    public function updateGroup(
        string $zoneID,
        string $packageID,
        string $groupID,
        string $status
    ): \stdClass {
        $query = [
            'mode' => $status
        ];

        $user = $this->adapter->patch(
            'zones/' . $zoneID . '/firewall/waf/packages/' . $packageID . '/groups/' . $groupID,
            $query
        );
        $this->body = json_decode($user->getBody());

        return $this->body->result;
    }
}
