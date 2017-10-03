<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 15:22
 */

namespace Cloudflare\API\Configurations;

class UARules implements Configurations
{
    private $configs = [];

    public function addUA(string $value)
    {
        $object = new \stdClass();
        $object->target = "ua";
        $object->value = $value;

        array_push($this->configs, $object);
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
