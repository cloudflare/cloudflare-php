<?php
/**
* Created by Notepad++.
* User: MertOtrk
* Date: 14/10/2017
* Time: 09:32
*/


use Cloudflare\API\Adapter\Adapter;

class Railgun implements \Cloudflare\API\Endpoints\API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Create Railgun
     * @return object
     */
    public function create(
        string $name = "",
    ): \stdClass {
		
        $query = [
        'name' => $name,
        ];

        $user = $this->adapter->post('railguns', [], $query);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }
	
    /**
     * List Railguns
     * @return object
     */
    public function list(
        int $page = 1,
        int $perPage = 20,
        string $direction = "",
    ): \stdClass {
        $query = [
        'page' => $page,
        'per_page' => $perPage
        ];
        
        if (!empty($direction)) {
            $query['direction'] = $direction;
        }
            
        $user = $this->adapter->get('railguns', $query, []);
        $body = json_decode($user->getBody());
        
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
        
        return $result;
    }
	
    /**
     * Get Railgun detail
     * @return object
     */
    public function get(
        string $id,
	): \stdClass {
            
        $user = $this->adapter->get('railguns/'.$id, [], []);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }
	
    /**
     * Get Railgun Zones
     * @return object
     */
    public function getZones(
        string $id,
	): \stdClass {
            
        $user = $this->adapter->get('railguns/'.$id.'/zones', [], []);
        $body = json_decode($user->getBody());
       
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
		
        return $result;
    }

    /**
     * Set Railgun Status
     * @return object
     */
    public function update(
        string $id,
		boolean $status,
    ): \stdClass {
        $query = [
        'enabled' => $status
        ];
        
        $user = $this->adapter->patch('railguns/'.$id, [], $query);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }

    /**
     * Delete Railgun
     * @return object
     */
    public function delete(
        string $id,
    ): \stdClass {
        
        $user = $this->adapter->delete('railguns/'.$id, [], []);
        $body = json_decode($user->getBody());
        
        if (isset($body->result->id)) {
            return true;
        }

        return false;
	}

}