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
     * @param string $accountID
     * @return mixed
     */
    public function listPools(string $accountID)
    {
        $pools = $this->adapter->get('accounts/' . $accountID . '/load_balancers/pools');
        $this->body = json_decode($pools->getBody());

        return $this->body->result;
    }

    /**
     * @param string $accountID
     * @param string $poolID
     * @return mixed
     */
    public function getPoolDetails(string $accountID, string $poolID)
    {
        $pool = $this->adapter->get('accounts/' . $accountID . '/load_balancers/pools/' . $poolID);
        $this->body = json_decode($pool->getBody());
        return $this->body->result;
    }

    /**
     * @param string $accountID
     * @param string $poolID
     * @return mixed
     */
    public function getPoolHealthDetails(string $accountID, string $poolID)
    {
        $pool = $this->adapter->get('accounts/' . $accountID . '/load_balancers/pools/' . $poolID . '/health');
        $this->body = json_decode($pool->getBody());
        return $this->body->result;
    }

    /**
     * @param string $accountID
     * @param string $poolID
     * @return Pool
     * @throws ConfigurationsException
     */
    public function getPoolConfiguration(string $accountID, string $poolID)
    {
        $pool = $this->getPoolDetails($accountID, $poolID);

        $origins = [];
        foreach ($pool->origins as $origin) {
            $origins[] = (array)$origin;
        }
        $poolConfiguration = new Pool($pool->name, $origins);
        $poolConfiguration->setDescription($pool->description);
        if ($pool->enabled === true) {
            $poolConfiguration->enable();
        } elseif ($pool->enabled === false) {
            $poolConfiguration->disable();
        }
        $poolConfiguration->setMonitor($pool->monitor);
        $poolConfiguration->setNotificationEmail($pool->notification_email);

        if (is_array($pool->check_regions)) {
            $poolConfiguration->setCheckRegions($pool->check_regions);
        }

        return $poolConfiguration;
    }

    /**
     * @param string $accountID
     * @param string $poolID
     * @param Pool $poolConfiguration
     * @return bool
     */
    public function updatePool(
        string $accountID,
        string $poolID,
        Pool $poolConfiguration
    ): bool {
        $options = $poolConfiguration->getArray();

        $query = $this->adapter->put('accounts/' . $accountID . '/load_balancers/pools/' . $poolID, $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $accountID
     * @param Pool $poolConfiguration
     * @return bool
     */
    public function createPool(
        string $accountID,
        Pool $poolConfiguration
    ): bool {
        $options = $poolConfiguration->getArray();

        $query = $this->adapter->post('accounts/' . $accountID . '/load_balancers/pools', $options);

        $this->body = json_decode($query->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $accountID
     * @param string $poolID
     * @return bool
     */
    public function deletePool(string $accountID, string $poolID): bool
    {
        $pool = $this->adapter->delete('accounts/' . $accountID . '/load_balancers/pools/' . $poolID);

        $this->body = json_decode($pool->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
