<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 05/09/2017
 * Time: 13:43
 */

namespace Cloudflare\API\Configurations;

class ZoneLockdown implements Configurations
{
    private $configs = [];

    public function addIP(string $value)
    {
        $object = (object)['target' => 'ip', 'value' => $value];

        array_push($this->configs, $object);
    }

    public function addIPRange(string $value)
    {
        $object = (object)['target' => 'ip_range', 'value' => $value];

        array_push($this->configs, $object);
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
