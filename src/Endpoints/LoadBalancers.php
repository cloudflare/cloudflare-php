<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\ConfigurationsException;
use Cloudflare\API\Configurations\LoadBalancer;
use Cloudflare\API\Traits\BodyAccessorTrait;

class LoadBalancers implements API
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
    public function listLoadBalancers(string $zoneID)
    {
        $loadBalancers = $this->adapter->get('zones/' . $zoneID . '/load_balancers');
        $this->body = json_decode($loadBalancers->getBody());

        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $loadBalancerID
     * @return mixed
     */
    public function getLoadBalancerDetails(string $zoneID, string $loadBalancerID)
    {
        $loadBalancer = $this->adapter->get('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID);
        $this->body = json_decode($loadBalancer->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $loadBalancerID
     * @return LoadBalancer
     * @throws ConfigurationsException
     */
    public function getLoadBalancerConfiguration(string $zoneID, string $loadBalancerID)
    {
        $loadBalancer = $this->getLoadBalancerDetails($zoneID, $loadBalancerID);

        $loadBalancerConfiguration = new LoadBalancer($loadBalancer->name, $loadBalancer->default_pools, $loadBalancer->fallback_pool);
        $loadBalancerConfiguration->setSteeringPolicy($loadBalancer->steering_policy);
        $loadBalancerConfiguration->setEnabled($loadBalancer->enabled);

        if (is_array($loadBalancer->pop_pools)) {
            $loadBalancerConfiguration->setPopPools($loadBalancer->pop_pools);
        }

        if (isset($loadBalancer->ttl)) {
            $loadBalancerConfiguration->setTtl($loadBalancer->ttl);
        }

        if (is_array($loadBalancer->region_pools)) {
            $loadBalancerConfiguration->setRegionPools($loadBalancer->region_pools);
        }
        $loadBalancerConfiguration->setSessionAffinity($loadBalancer->session_affinity);
        $loadBalancerConfiguration->setDescription($loadBalancer->description);
        $loadBalancerConfiguration->setProxied($loadBalancer->proxied);

        if (isset($loadBalancer->session_affinity_ttl)) {
            $loadBalancerConfiguration->setSessionAffinityTtl($loadBalancer->session_affinity_ttl);
        }

        return $loadBalancerConfiguration;
    }

    /**
     * @param string $zoneID
     * @param string $loadBalancerID
     * @param LoadBalancer $loadBalancerConfiguration
     * @return bool
     */
    public function updateLoadBalancer(
        string $zoneID,
        string $loadBalancerID,
        LoadBalancer $loadBalancerConfiguration
    ): bool {
        $options = $loadBalancerConfiguration->getArray();

        $query = $this->adapter->patch('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID, $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $zoneID
     * @param LoadBalancer $loadBalancerConfiguration
     * @return bool
     */
    public function createLoadBalancer(
        string $zoneID,
        LoadBalancer $loadBalancerConfiguration
    ): bool {
        $options = $loadBalancerConfiguration->getArray();

        $query = $this->adapter->post('zones/' . $zoneID . '/load_balancers', $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $zoneID
     * @param string $loadBalancerID
     * @return bool
     */
    public function deleteLoadBalancer(string $zoneID, string $loadBalancerID): bool
    {
        $loadBalancer = $this->adapter->delete('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID);

        $this->body = json_decode($loadBalancer->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
