<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 16/01/2023
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class WorkersRoute implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $zoneID
     * @return mixed
     */
    public function listRoutes(string $zoneID)
    {
        $workerRoutes = $this->adapter->get('zones/' . $zoneID . '/workers/routes');
        $this->body = json_decode($workerRoutes->getBody());

        return $this->body->result;
    }

    public function getRoute(string $zoneID, string $routeID)
    {
        $workerRoutes = $this->adapter->get('zones/' . $zoneID . '/workers/routes/' . $routeID);
        $this->body = json_decode($workerRoutes->getBody());

        return $this->body->result;
    }

    public function createRoute(string $zoneID, string $pattern, ?string $script = null)
    {
        $options = [
            'pattern' => $pattern
        ];

        if($script) {
            $options['script'] = $script;
        }

        $query = $this->adapter->post('zones/' . $zoneID . '/workers/routes', $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function updateRoute(string $zoneID, string $routeID, string $pattern, ?string $script = null)
    {
        $options = [
            'pattern' => $pattern
        ];

        if($script) {
            $options['script'] = $script;
        }

        $query = $this->adapter->put('zones/' . $zoneID . '/workers/routes/' . $routeID, $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function deleteRoute(string $zoneID, string $routeID)
    {
        $workerRoutes = $this->adapter->delete('zones/' . $zoneID . '/workers/routes/' . $routeID);
        $this->body = json_decode($workerRoutes->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
