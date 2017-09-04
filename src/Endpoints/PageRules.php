<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 16:17
 */

namespace Cloudflare\API\Adapter;


use Cloudflare\API\Endpoints\API;

class PageRules implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}