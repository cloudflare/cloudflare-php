<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

namespace Cloudflare\API\Configurations;

class Pool implements Configurations
{
    private $configs = [];

    public function __construct(string $name, array $origins)
    {
        $this->setName($name);
        $this->setOrigins($origins);
    }

    public function setName(string $name)
    {
        $this->configs['name'] = $name;
    }

    public function getName():string
    {
        return $this->configs['name'] ?? '';
    }

    public function setOrigins(array $origins)
    {
        foreach ($origins as $origin) {
            if (!isset($origin['name'])) {
                throw new ConfigurationsException('name is required for origin');
            }
            if (!isset($origin['address'])) {
                throw new ConfigurationsException('address is required for origin');
            }
        }
        $this->configs['origins'] = $origins;
    }

    public function getOrigins():array
    {
        return $this->configs['origins'] ?? [];
    }

    public function setDescription(string $description = '')
    {
        $this->configs['description'] = $description;
    }

    public function getDescription():string
    {
        return $this->configs['description'] ?? '';
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

    public function setMonitor(string $monitor)
    {
        $this->configs['monitor'] = $monitor;
    }

    public function getMonitor():string
    {
        return $this->configs['monitor'] ?? '';
    }

    public function setCheckRegions(array $checkRegions)
    {
        $this->configs['check_regions'] = $checkRegions;
    }

    public function getCheckRegions():array
    {
        return $this->configs['check_regions'] ?? [];
    }

    public function setNotificationEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new ConfigurationsException('Invalid notification email given');
        }

        $this->configs['notification_email'] = $email;
    }

    public function getNotificationEmail():string
    {
        return $this->configs['notification_email'] ?? '';
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
