<?php

namespace Cloudflare\API\Configurations;

class AccessRules
{
    private $config;

    public function setIP(string $value)
    {
        $this->config = (object)['target' => 'ip', 'value' => $value];
    }

    public function setIPRange(string $value)
    {
        $this->config = (object)['target' => 'ip_range', 'value' => $value];
    }

    public function setCountry(string $value)
    {
        $this->config = (object)['target' => 'country', 'value' => $value];
    }

    public function getObject(): \stdClass
    {
        return $this->config;
    }
}
