<?php
/**
* Created by Notepad++.
* User: MertOtrk
* Date: 14/10/2017
* Time: 09:32
*/


namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Railgun implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function create(
        string $name
    ): \stdClass {
        $query = [
        'name' => $name,
        ];

        $user = $this->adapter->post('railguns', [], $query);
        $body = json_decode($user->getBody());
        
        return $body;
    }

    public function list(
        int $page = 1,
        int $perPage = 20,
        string $direction = ""
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

    public function get(
        string $railID
    ): \stdClass {
        $user = $this->adapter->get('railguns/'.$railID, [], []);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }
    
    public function getZones(
        string $railID
    ): \stdClass {
        $user = $this->adapter->get('railguns/'.$railID.'/zones', [], []);
        $body = json_decode($user->getBody());
       
        $result = new \stdClass();
        $result->result = $body->result;
        $result->result_info =  $body->result_info;
        
        return $result;
    }

    public function update(
        string $railID,
        bool $status
    ): \stdClass {
        $query = [
        'enabled' => $status
        ];
        
        $user = $this->adapter->patch('railguns/'.$railID, [], $query);
        $body = json_decode($user->getBody());
        
        return $body->result;
    }

    public function delete(
        string $railID
    ):bool {
        $user = $this->adapter->delete('railguns/'.$railID, [], []);
        $body = json_decode($user->getBody());
        
        if (isset($body->result->id)) {
            return true;
        }

        return false;
    }
}
