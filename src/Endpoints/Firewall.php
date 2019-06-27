<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Firewall implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function createFirewallRules(
        string $zoneID,
        array $rules
    ): array {
        $query = $this->adapter->post('zones/' . $zoneID . '/firewall/rules', $rules);
        $body = json_decode($query->getBody());

        return $body->result;
    }

    public function createFirewallRule(
        string $zoneID,
        string $expression,
        string $action,
        string $description = null,
        bool $paused = false,
        int $priority = null
    ): array {
        $rule = [
            'filter' => [
                'expression' => $expression,
                'paused' => false
            ],
            'action' => $action,
            'paused' => $paused
        ];

        if ($description !== null) {
            $rule['description'] = $description;
        }

        if ($priority !== null) {
            $rule['priority'] = $priority;
        }

        return $this->createFirewallRules($zoneID, [$rule]);
    }

    public function listFirewallRules(
        string $zoneID,
        int $page = 1,
        int $perPage = 50
    ): array {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
        ];

        $rules = $this->adapter->get('zones/' . $zoneID . '/firewall/rules', $query);
        $body = json_decode($rules->getBody());

        return $body->result;
    }

    public function deleteFirewallRule(
        string $zoneID,
        string $ruleID
    ): bool {
        $rule = $this->adapter->delete('zones/' . $zoneID . '/firewall/rules/' . $ruleID);

        $body = json_decode($rule->getBody());

        if (isset($body->result->id)) {
            return true;
        }

        return false;
    }

    public function updateFirewallRule(
        string $zoneID,
        string $ruleID,
        string $filterID,
        string $expression,
        string $action,
        string $description = null,
        bool $paused = true,
        int $priority = null
    ): \stdClass {
        $rule = [
            'id' => $ruleID,
            'filter' => [
                'id' => $filterID,
                'expression' => $expression,
                'paused' => false
            ],
            'action' => $action,
            'paused' => $paused
        ];

        if ($description !== null) {
            $rule['description'] = $description;
        }

        if ($priority !== null) {
            $rule['priority'] = $priority;
        }

        $rule = $this->adapter->put('zones/' . $zoneID . '/firewall/rules/' . $ruleID, $rule);
        $body = json_decode($rule->getBody());

        return $body->result;
    }
}
