<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class ZoneSubscriptions implements API
{
    use BodyAccessorTrait;

    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function listZoneSubscriptions(string $zoneId): \stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneId . '/subscriptions');
        $this->body = json_decode($user->getBody());

        return (object)[
            'result' => $this->body->result,
        ];
    }

    public function addZoneSubscription(string $zoneId, string $ratePlanId = ''): stdClass
    {
        $options = [];

        if (empty($ratePlanId) === false) {
            $options['rate_plan'] = [
                'id' => $ratePlanId,
            ];
        }

        $existingSubscription = $this->listZoneSubscriptions($zoneId);
        $method               = empty($existingSubscription->result) ? 'post' : 'put';

        $subscription = $this->adapter->{$method}('zones/' . $zoneId . '/subscription', $options);
        $this->body   = json_decode($subscription->getBody());

        return $this->body->result;
    }
}
