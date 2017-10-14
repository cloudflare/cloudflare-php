<?php
/**
* Created by Notepad++.
* User: MertOtrk
* Date: 12/10/2017
* Time: 05:32
*/

namespace Cloudflare\API\Endpoints\Zones;

use Cloudflare\API\Adapter\Adapter;

class WAF implements \Cloudflare\API\Endpoints\API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }


    /* Functions */


    /**
     * List Web Application Firewall Packages
     * @return object
     */
    public function getPackages(
        string $zoneID,
        int $page = 1,
        int $perPage = 20,
        string $order = "",
        string $direction = "",
        string $match = "all"
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
            
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages', $query, []);
        $body = json_decode($user->getBody());
        
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
        
        return $result;
    }

    /**
     * Web Application Firewall Package Info
     * @return object
     */
    public function getPackageInfo(
        string $zoneID,
        string $packageID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID, [], []);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }


    /* Rules */



    /**
     * List Web Application Firewall Package Rules
     * @return object
     */
    public function getRules(
        string $zoneID,
        string $packageID,
        int $page = 1,
        int $perPage = 20,
        string $order = "",
        string $direction = "",
        string $match = "all"
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
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/rules', $query, []);
        $body = json_decode($user->getBody());
        
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
        
        return $result;
    }

    /**
     * Web Application Firewall Package Rule Info
     * @return object
     */

    public function getRuleInfo(
        string $zoneID,
        string $packageID,
        string $ruleID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, [], []);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }

    /**
     * Web Application Firewall Package Rule Update
     * @return object
     */
    public function updateRule(
        string $zoneID,
        string $packageID,
        string $ruleID,
        string $status
    ): \stdClass {
        $query = [
            'mode' => $status,
        ];
        
        $user = $this->adapter->patch('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, [], $query);
        $body = json_decode($user->getBody());
                
        return $body->result;
    }

        
        
    /* Groups */
        
    /**
     * List Web Application Firewall Package Groups
     * @return object
     */
    public function getGroups(
        string $zoneID,
        string $packageID,
        int $page = 1,
        int $perPage = 20,
        string $order = "",
        string $direction = "",
        string $match = "all"
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
        
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/groups', $query, []);
        $body = json_decode($user->getBody());
        
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
        
        return $result;
    }


    /**
     * Web Application Firewall Package Group Info
     * @return object
     */
    public function getGroupInfo(
        string $zoneID,
        string $packageID,
        string $groupID
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, [], []);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }


    /**
     * Web Application Firewall Package Group Update
     * @return object
     */
    public function updateGroup(
        string $zoneID,
        string $packageID,
        string $groupID,
        string $status
    ): \stdClass {
        $query = [
        'mode' => $status
        ];
        
        $user = $this->adapter->patch('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, [], $query);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }
}
