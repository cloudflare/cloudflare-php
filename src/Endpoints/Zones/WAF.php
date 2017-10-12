<?php
/**
	* Created by Notepad++.
	* User: MertOtrk
	* Date: 12/10/2017
	* Time: 05:32
	----*
	
	$zones = new \Cloudflare\API\Endpoints\Zones\WAF($adapter);
	$zones->setZone("8955d96e04c9dfd2c98af300c95f08d4");
	
	---*
	-- Example
	---*
	
	+
	$zones->setDirection("desc")->WAFPackages();
	-- Seems to
	$zones->setDirection("desc");
	$zones->WAFPackages();
	+
 */

namespace Cloudflare\API\Endpoints\Zones;

use Cloudflare\API\Adapter\Adapter;

class WAF implements \Cloudflare\API\Endpoints\API
{
    private $adapter;
    private $zoneID;
    private $page = 1;
    private $perpage = 20;
    private $order = 20;
    private $direction = "desc";
    private $match = "all";

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
	
    /**
     * Set ZoneID
     * @param string $zoneID
     */
    public function setZone($zoneID)
    {
        $this->zoneID = $zoneID;
		return $this;
    }
	
    /**
     * Set Page number
     * @param $page
     */
    public function setPage($page)
    {
        $this->page = $page;
		return $this;
    }
	
    /**
     * Set Per Page number
     * @param $perpage
     */
    public function setPerPage($perpage)
    {
        $this->perpage = $perpage;
		return $this;
    }
	
    /**
     * Set Per Page number
     * @param $perpage
     */
    public function setOrder($order)
    {
        $this->order = $order;
		return $this;
    }
	
    /**
     * Set Direction
     * @param $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
		return $this;
    }
	
    /**
     * Set Match
     * @param int $match
     */
    public function setMatch($match)
    {
        $this->match = $match;
		return $this;
    }
	
    /**
     * Reset Queries
     */
    private function WAFresetQueries()
    {
		$this->page = 1;
		$this->perpage = 20;
		$this->order = 20;
		$this->direction = "desc";
		$this->match = "all";
    }
	
	
	
	
    /* Functions */
	
	
    /**
     * List Web Application Firewall Packages
     * @return object
     */
    public function WAFPackages(): \stdClass
    {
        $query = [
            'page' => $this->page,
            'per_page' => $this->perpage,
            'order' => $this->order,
            'direction' => $this->direction,
            'match' => $this->match
		];
		
		$this->WAFresetQueries();
		
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages', $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		$result->result_info = @count($body->result_info) ? $body->result_info : null;
		
		return $result;
    }
	
    /**
     * Web Application Firewall Package Info - Same Results: ListWAFPackages
     * @return object
     */
    public function WAFPackageInfo(string $packageID): \stdClass
    {
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID, [], []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		
		return $result;
    }
	
	
    /* Rules */

	
	
    /**
     * List Web Application Firewall Package Rules
     * @return object
     */
    public function WAFRules(string $packageID): \stdClass
    {
        $query = [
            'page' => $this->page,
            'per_page' => $this->perpage,
            'order' => $this->order,
            'direction' => $this->direction,
            'match' => $this->match
		];
		
		$this->WAFresetQueries();
		
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/rules', $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		$result->result_info = @count($body->result_info) ? $body->result_info : null;
		
		return $result;
    }
	
    /**
     * Web Application Firewall Package Rule Info - Same Results: WAFRules
     * @return object
     */
    public function WAFRuleInfo(string $packageID, string $ruleID): \stdClass
    {
        $query = [
            'page' => $this->page,
            'per_page' => $this->perpage,
            'order' => $this->order,
            'direction' => $this->direction,
            'match' => $this->match
		];
		
		$this->WAFresetQueries();
		
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		
		return $result;
    }
	
    /**
     * Web Application Firewall Package Rule Update
     * @return object
     */
    public function WAFRuleUpdate(string $packageID, string $ruleID, bool $status): \stdClass
    {

		$this->WAFresetQueries();

		$status = $status == "true" ? "on" : "off";
		
        $query = [
            'mode' => $status
		];
		
        $user = $this->adapter->patch('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		
		return $result;
    }

		
		
    /* Groups */
		
    /**
     * List Web Application Firewall Package Groups
     * @return object
     */
    public function WAFGroups(string $packageID): \stdClass
    {
        $query = [
            'page' => $this->page,
            'per_page' => $this->perpage,
            'order' => $this->order,
            'direction' => $this->direction,
            'match' => $this->match
		];
		
		$this->WAFresetQueries();
		
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/groups', $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		$result->result_info = @count($body->result_info) ? $body->result_info : null;
		
		return $result;
    }
	
	
    /**
     * Web Application Firewall Package Group Info - Same Results: ListWAFGroups
     * @return object
     */
    public function WAFGroupInfo(string $packageID, $groupID): \stdClass
    {
        $user = $this->adapter->get('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, [], []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		
		return $result;
    }
	

    /**
     * Web Application Firewall Package Rule Update
     * @return object
     */
    public function WAFGroupUpdate(string $packageID, string $groupID, bool $status): \stdClass
    {

		$this->WAFresetQueries();

		$status = $status == "true" ? "on" : "off";
		
        $query = [
            'mode' => $status
		];
		
        $user = $this->adapter->patch('zones/' . $this->zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, $query, []);
        $body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = @count($body->result) ? $body->result : null;
		
		return $result;
    }

	
}
