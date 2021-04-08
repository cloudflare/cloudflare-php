<?php

namespace Cloudflare\API\Test\Configurations;

use Cloudflare\API\Configurations\PageRulesTargets;
use Cloudflare\API\Test\TestCase;

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 18:41
 */
class PageRulesTargetTest extends TestCase
{
    public function testGetArray()
    {
        $targets = new PageRulesTargets('junade.com/*');
        $array = $targets->getArray();

        $this->assertCount(1, $array);
        $this->assertEquals('junade.com/*', $array[0]['constraint']['value']);
        $this->assertEquals('matches', $array[0]['constraint']['operator']);
    }
}
