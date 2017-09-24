<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 18:37
 */

namespace Cloudflare\API\Configurations;

class PageRulesTargets implements Configurations
{
    private $targets;

    public function __construct(string $queryUrl)
    {
        $target = new \stdClass();
        $target->target = 'url';
        $target->constraint = new \stdClass();
        $target->constraint->operator = "matches";
        $target->constraint->value = $queryUrl;

        $this->targets = [$target];
    }

    public function getArray(): array
    {
        return $this->targets;
    }
}
