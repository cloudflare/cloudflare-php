<?php

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 05/09/2017
 * Time: 13:50
 */
 
use PHPUnit_Framework_TestCase as TestBase;
class ConfigurationZoneLockdownTest extends TestBase
{
    public function testGetArray()
    {
        $configuration = new \Cloudflare\API\Configurations\ZoneLockdown();
        $configuration->addIP('1.2.3.4');

        $array = $configuration->getArray();
        $this->assertEquals(1, sizeof($array));

        $this->assertObjectHasAttribute('target', $array[0]);
        $this->assertEquals('ip', $array[0]->target);
        $this->assertObjectHasAttribute('value', $array[0]);
        $this->assertEquals('1.2.3.4', $array[0]->value);

        $configuration->addIPRange('1.2.3.4/24');

        $array = $configuration->getArray();
        $this->assertEquals(2, sizeof($array));

        $this->assertObjectHasAttribute('target', $array[1]);
        $this->assertEquals('ip_range', $array[1]->target);
        $this->assertObjectHasAttribute('value', $array[1]);
        $this->assertEquals('1.2.3.4/24', $array[1]->value);
    }
}
