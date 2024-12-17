<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 15:45
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Zones implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $name
     * @param bool $jumpStart
     * @param string $accountId
     * @return \stdClass
     */
    public function addZone(string $name, bool $jumpStart = false, string $accountId = ''): \stdClass
    {
        $options = [
            'name' => $name,
            'jump_start' => $jumpStart
        ];

        if (!empty($accountId)) {
            $options['account'] = [
                'id' => $accountId,
            ];
        }

        $user = $this->adapter->post('zones', $options);
        $this->body = json_decode($user->getBody());
        return $this->body->result;
    }

    public function activationCheck(string $zoneID): bool
    {
        $user = $this->adapter->put('zones/' . $zoneID . '/activation_check');
        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function pause(string $zoneID): bool
    {
        $user = $this->adapter->patch('zones/' . $zoneID, ['paused' => true]);
        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function unpause(string $zoneID): bool
    {
        $user = $this->adapter->patch('zones/' . $zoneID, ['paused' => false]);
        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    public function getZoneById(
        string $zoneId
    ): \stdClass {
        $user = $this->adapter->get('zones/' . $zoneId);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result];
    }

    public function listZones(
        string $name = '',
        string $status = '',
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

        if (!empty($name)) {
            $query['name'] = $name;
        }

        if (!empty($status)) {
            $query['status'] = $status;
        }

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('zones', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getZoneID(string $name = ''): string
    {
        $zones = $this->listZones($name);

        if (count($zones->result) < 1) {
            throw new EndpointException('Could not find zones with specified name.');
        }

        return $zones->result[0]->id;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $zoneID
     * @param string $since
     * @param string $until
     * @param bool $continuous
     * @return \stdClass
     */
    public function getAnalyticsDashboard(string $zoneID, string $since = '-10080', string $until = '0', bool $continuous = true): \stdClass
    {
        $response = $this->adapter->get('zones/' . $zoneID . '/analytics/dashboard', ['since' => $since, 'until' => $until, 'continuous' => var_export($continuous, true)]);

        $this->body = $response->getBody();

        return json_decode($this->body)->result;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $zoneID
     * @param bool $enable
     * @return bool
     */
    public function changeDevelopmentMode(string $zoneID, bool $enable = false): bool
    {
        $response = $this->adapter->patch('zones/' . $zoneID . '/settings/development_mode', ['value' => $enable ? 'on' : 'off']);

        $this->body = json_decode($response->getBody());

        if ($this->body->success) {
            return true;
        }

        return false;
    }

    /**
     * Return caching level settings
     * @param string $zoneID
     * @return string
     */
    public function getCachingLevel(string $zoneID): string
    {
        $response = $this->adapter->get('zones/' . $zoneID . '/settings/cache_level');

        $this->body = json_decode($response->getBody());

        return $this->body->result->value;
    }

    /**
     * Change caching level settings
     * @param string $zoneID
     * @param string $level (aggressive | basic | simplified)
     * @return bool
     */
    public function setCachingLevel(string $zoneID, string $level = 'aggressive'): bool
    {
        $response = $this->adapter->patch('zones/' . $zoneID . '/settings/cache_level', ['value' => $level]);

        $this->body = json_decode($response->getBody());

        if ($this->body->success) {
            return true;
        }

        return false;
    }

    /**
     * Purge Everything
     * @param string $zoneID
     * @return bool
     *
     * @SuppressWarnings(PHPMD)
     */
    public function cachePurgeEverything(string $zoneID, bool $includeEnvironments = false): bool
    {
        if ($includeEnvironments) {
            $env = $this->adapter->get("zones/$zoneID/environments");
            $envs = json_decode($env->getBody(), true);
            foreach ($envs["result"]["environments"] as $env) {
                $this->adapter->post("zones/$zoneID/environments/{$env["ref"]}/purge_cache", ['purge_everything' => true]);
            }
        }
        $user = $this->adapter->post('zones/' . $zoneID . '/purge_cache', ['purge_everything' => true]);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function cachePurge(string $zoneID, array $files = null, array $tags = null, array $hosts = null, bool $includeEnvironments = false): bool
    {
        if ($files === null && $tags === null && $hosts === null) {
            throw new EndpointException('No files, tags or hosts to purge.');
        }

        $options = [];
        if (!is_null($files)) {
            $options['files'] = $files;
        }

        if (!is_null($tags)) {
            $options['tags'] = $tags;
        }

        if (!is_null($hosts)) {
            $options['hosts'] = $hosts;
        }

        if ($includeEnvironments) {
            $env = $this->adapter->get("zones/$zoneID/environments");
            $envs = json_decode($env->getBody(), true);
            foreach ($envs["result"]["environments"] as $env) {
                $this->adapter->post("zones/$zoneID/environments/{$env["ref"]}/purge_cache", $options);
            }
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/purge_cache', $options);

        $this->body = json_decode($user->getBody());

        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }

    /**
     * Delete Zone
     */
    public function deleteZone(string $identifier): bool
    {
        $user = $this->adapter->delete('zones/' . $identifier);
        $this->body = json_decode($user->getBody());
        if (isset($this->body->result->id)) {
            return true;
        }

        return false;
    }
}
