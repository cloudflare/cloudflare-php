<?php

namespace Cloudflare\API\Configurations;

class AccessRules implements Configurations
{
    private $config;

    public function setIP(string $value)
    {
        if (strpos($value, ':') !== false) {
          $this->config = ['target' => 'ip6', 'value' => $value];
        } else {
          $this->config = ['target' => 'ip', 'value' => $value];
        }
    }

    public function setIPRange(string $value)
    {
        $this->config = ['target' => 'ip_range', 'value' => $value];
    }

    public function setCountry(string $value)
    {
        $this->config = ['target' => 'country', 'value' => $value];
    }

    public function setASN(string $value)
    {
        $this->config = ['target' => 'asn', 'value' => $value];
    }

    public function getArray(): array
    {
        return $this->config;
    }
}
