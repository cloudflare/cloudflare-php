<?php
namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Cache implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function deleteFilesFromCache(string $zone, array $files): \stdClass
    {
        $cache = $this->adapter->delete('zones/' . $zone . '/purge_cache', [], [ 'files' => $files ]);
        $body = json_decode($cache->getBody());
        return $body->result;
    }
}
