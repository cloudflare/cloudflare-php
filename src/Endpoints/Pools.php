<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\ConfigurationsException;
use Cloudflare\API\Configurations\Pool;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Pools implements API
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
    public function listPools(string $zoneID)
    {
        $pools = $this->adapter->get('zones/' . $zoneID . '/load_balancers/pools');
        $this->body = json_decode($pools->getBody());

        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $poolID
     * @return mixed
     */
    public function getPoolDetails(string $zoneID, string $poolID)
    {
        $pool = $this->adapter->get('zones/' . $zoneID . '/load_balancers/pools/' . $poolID);
        $this->body = json_decode($pool->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $poolID
     * @return mixed
     */
    public function getPoolHealthDetails(string $zoneID, string $poolID)
    {
        $pool = $this->adapter->get('zones/' . $zoneID . '/load_balancers/pools/' . $poolID . '/health');
        $this->body = json_decode($pool->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $poolID
     * @return Pool
     * @throws ConfigurationsException
     */
    public function getPoolConfiguration(string $zoneID, string $poolID)
    {
        $pool = $this->getPoolDetails($zoneID, $poolID);

        $poolConfiguration = new Pool($pool->name, $pool->origins);
        $poolConfiguration->setDescription($pool->description);
        $poolConfiguration->setEnabled($pool->enabled);
        $poolConfiguration->setMonitor($pool->monitor);
        $poolConfiguration->setNotificationEmail($pool->notification_email);

        return $poolConfiguration;
    }

    /**
     * @param string $zoneID
     * @param string $poolID
     * @param Pool $poolConfiguration
     * @return bool
     */
    public function updatePool(
        string $zoneID,
        string $poolID,
        Pool $poolConfiguration
    ): bool {
        $options = $poolConfiguration->getArray();

        $query = $this->adapter->patch('zones/' . $zoneID . '/load_balancers/pools/' . $poolID, $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $zoneID
     * @param Pool $poolConfiguration
     * @return bool
     */
    public function createPool(
        string $zoneID,
        Pool $poolConfiguration
    ): bool {
        $options = $poolConfiguration->getArray();

        $query = $this->adapter->post('zones/' . $zoneID . '/load_balancers/pools', $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $zoneID
     * @param string $poolID
     * @return bool
     */
    public function deletePool(string $zoneID, string $poolID): bool
    {
        $pool = $this->adapter->delete('zones/' . $zoneID . '/load_balancers/pools/' . $poolID);

        $this->body = json_decode($pool->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
