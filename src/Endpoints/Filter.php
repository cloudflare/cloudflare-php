<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\FirewallRuleOptions;

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
    ): bool {
        $query = $this->adapter->post('zones/' . $zoneID . '/firewall/rules', $rules);
        $body = json_decode($query->getBody());

        foreach ($body->result as $result) {
            if (!isset($result->id)) {
                return false;
            }
        }

        return true;
    }

    public function createFirewallRule(
        string $zoneID,
        string $expression,
        FirewallRuleOptions $options,
        string $description = null,
        int $priority = null
    ): bool {
        $rule = array_merge([
            'filter' => [
                'expression' => $expression,
                'paused' => false
            ]
        ], $options->getArray());

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
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
        ];

        $rules = $this->adapter->get('zones/' . $zoneID . '/firewall/rules', $query);
        $body = json_decode($rules->getBody());

        return (object)['result' => $body->result, 'result_info' => $body->result_info];
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
        FirewallRuleOptions $options,
        string $description = null,
        int $priority = null
    ): \stdClass {
        $rule = array_merge([
            'id' => $ruleID,
            'filter' => [
                'id' => $filterID,
                'expression' => $expression,
                'paused' => false
            ]
        ], $options->getArray());

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
