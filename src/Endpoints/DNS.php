<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 15:14
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class DNS implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addRecord(string $zoneID, string $type, string $name, string $content, int $ttl = 0, bool $proxied = true): bool
    {
        $options = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'proxied' => $proxied
        ];

        if ($ttl > 0) {
            $options['ttl'] = $ttl;
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/dns_records', [], $options);

        $body = json_decode($user->getBody());

        if (isset($body->result->id)) {
            return true;
        }

        return false;
    }

}