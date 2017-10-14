<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 18:41
 */

use Cloudflare\API\Configurations\PageRulesTargets;
use PHPUnit_Framework_TestCase as TestBase;

class PageRulesTargetTest extends TestBase
{
    public function testGetArray()
    {
        $targets = new PageRulesTargets('junade.com/*');
        $array = $targets->getArray();

        $this->assertEquals(1, sizeof($array));
        $this->assertEquals("junade.com/*", $array[0]->constraint->value);
        $this->assertEquals("matches", $array[0]->constraint->operator);
    }
}
