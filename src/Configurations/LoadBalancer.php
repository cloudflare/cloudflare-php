<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

namespace Cloudflare\API\Configurations;

class LoadBalancer implements Configurations
{
    private $configs = [];

    public function __construct(string $name, array $defaultPools, string $fallbackPool)
    {
        $this->setName($name);
        $this->setDefaultPools($defaultPools);
        $this->setFallbackPool($fallbackPool);
    }

    public function setName(string $name)
    {
        $this->configs['name'] = $name;
    }

    public function getName():string
    {
        return $this->configs['name'] ?? '';
    }

    public function setDefaultPools(array $defaultPools)
    {
        $this->configs['default_pools'] = $defaultPools;
    }

    public function getDefaultPools():array
    {
        return $this->configs['default_pools'] ?? [];
    }

    public function setFallbackPool(string $fallbackPool)
    {
        $this->configs['fallback_pools'] = $fallbackPool;
    }

    public function getFallbackPool():string
    {
        return $this->configs['fallback_pools'] ?? '';
    }

    public function setSteeringPolicy(string $steeringPolicy = '')
    {
        $allowedOptions = ['off', 'geo', 'random', 'dynamic_latency', ''];
        if (!in_array($steeringPolicy, $allowedOptions)) {
            throw new ConfigurationsException('Given steering policy value is not a valid option, valid options are: ' . implode(', ', $allowedOptions));
        }

        $this->configs['steering_policy'] = $steeringPolicy;
    }

    public function getSteeringPolicy():string
    {
        return $this->configs['steering_policy'] ?? '';
    }

    public function enable()
    {
        $this->configs['enabled'] = true;
    }

    public function isEnabled():bool
    {
        return $this->configs['enabled'] ?? true;
    }

    public function disable()
    {
        $this->configs['enabled'] = false;
    }

    public function isDisabled():bool
    {
        return !$this->configs['enabled'] ?? false;
    }

    public function getEnabled():bool
    {
        return $this->configs['enabled'] ?? true;
    }

    public function setPopPools(array $popPools)
    {
        $this->configs['pop_pools'] = $popPools;
    }

    public function getPopPools():array
    {
        return $this->configs['pop_pools'] ?? [];
    }

    public function setTtl(int $ttl)
    {
        $this->configs['ttl'] = $ttl;
    }

    public function getTtl():int
    {
        return $this->configs['ttl'] ?? 30;
    }

    public function setRegionPools(array $regionPools)
    {
        $this->configs['region_pools'] = $regionPools;
    }

    public function getRegionPools():array
    {
        return $this->configs['region_pools'] ?? [];
    }

    public function setSessionAffinity(string $sessionAffinity = '')
    {
        $allowedOptions = ['none', 'cookie', 'ip_cookie', ''];
        if (!in_array($sessionAffinity, $allowedOptions)) {
            throw new ConfigurationsException('Given session affinity value is not a valid option, valid options are: ' . implode(', ', $allowedOptions));
        }
        $this->configs['session_affinity'] = $sessionAffinity;
    }

    public function getSessionAffinity():string
    {
        return $this->configs['session_affinity'] ?? '';
    }

    public function setDescription(string $description = '')
    {
        $this->configs['description'] = $description;
    }

    public function getDescription():string
    {
        return $this->configs['description'] ?? '';
    }

    public function enableProxied()
    {
        $this->configs['proxied'] = true;
    }

    public function disableProxied()
    {
        $this->configs['proxied'] = false;
    }

    public function isProxied():bool
    {
        return $this->configs['proxied'] ?? true;
    }

    public function setSessionAffinityTtl(int $sessionAffinityTtl = 82800)
    {
        if ($sessionAffinityTtl > 604800 || $sessionAffinityTtl < 1800) {
            throw new ConfigurationsException('The value of session affinity ttl must be between 1800 and 604800');
        }

        $this->configs['session_affinity_ttl'] = $sessionAffinityTtl;
    }

    public function getSessionAffinityTtl():int
    {
        return $this->configs['session_affinity_ttl'] ?? 82800;
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
