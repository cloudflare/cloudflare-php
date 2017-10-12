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
	public function WAFPackages(
		string $zoneID,
		int $page = 1,
		int $perPage = 20,
		string $order = "",
		string $direction = "",
		string $match = "all"
	): \stdClass
	{
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
	 * Web Application Firewall Package Info - Same Results: ListWAFPackages
	 * @return object
	 */
	public function WAFPackageInfo(
		string $zoneID,
		string $packageID
	): \stdClass
	{
		$user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID, [], []);
		$body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = $body->result;
		
		return $result;
	}


	/* Rules */



	/**
	 * List Web Application Firewall Package Rules
	 * @return object
	 */
	public function WAFRules(
		string $zoneID,
		string $packageID,
		int $page = 1,
		int $perPage = 20,
		string $order = "",
		string $direction = "",
		string $match = "all"
	): \stdClass
	{
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
	 * Web Application Firewall Package Rule Info - Same Results: WAFRules
	 * @return object
	 */

	public function WAFRuleInfo(
		string $zoneID,
		string $packageID,
		string $ruleID,
		int $page = 1,
		int $perPage = 20,
		string $order = "",
		string $direction = "",
		string $match = "all"
	): \stdClass
	{
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
			
		$user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, $query, []);
		$body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = $body->result;
		
		return $result;
	}

	/**
	 * Web Application Firewall Package Rule Update
	 * @return object
	 */
	public function WAFRuleUpdate(
		string $zoneID, 
		string $packageID, 
		string $ruleID, 
		bool $status
	): \stdClass
	{

		$status = $status == "true" ? "on" : "off";
		
		$query = [
		'mode' => $status
		];
		
		$user = $this->adapter->patch('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/rules/'.$ruleID, $query, []);
		$body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = $body->result;
		
		return $result;
	}

		
		
	/* Groups */
		
	/**
	 * List Web Application Firewall Package Groups
	 * @return object
	 */
	public function WAFGroups(
		string $zoneID,
		string $packageID,
		int $page = 1,
		int $perPage = 20,
		string $order = "",
		string $direction = "",
		string $match = "all"
	): \stdClass
	{
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
	 * Web Application Firewall Package Group Info - Same Results: ListWAFGroups
	 * @return object
	 */
	public function WAFGroupInfo(
		string $zoneID,
		string $packageID, 
		string $groupID
	): \stdClass
	{
		$user = $this->adapter->get('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, [], []);
		$body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = $body->result;
		
		return $result;
	}


	/**
	 * Web Application Firewall Package Rule Update
	 * @return object
	 */
	public function WAFGroupUpdate(
		string $zoneID, 
		string $packageID,
		string $groupID, 
		bool $status
	): \stdClass
	{

		$status = $status == "true" ? "on" : "off";
		
		$query = [
		'mode' => $status
		];
		
		$user = $this->adapter->patch('zones/' . $zoneID . '/firewall/waf/packages/'.$packageID.'/groups/'.$groupID, $query, []);
		$body = json_decode($user->getBody());
		
		$result = new \stdClass();
		$result->result = $body->result;
		
		return $result;
	}


}
