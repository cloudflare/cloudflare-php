<?php

namespace Cloudflare\API\Configurations;

class AccessRules implements Configurations
{
    private $configs = [];

    public function setIP(string $value)
    {
        $this->configs[] = (object)['target' => 'ip', 'value' => $value];
    }

    public function setIPRange(string $value)
    {
        $this->configs[] = (object)['target' => 'ip_range', 'value' => $value];
    }

    public function setCountry(string $value)
    {
        $this->configs[] = (object)['target' => 'country', 'value' => $value];
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
