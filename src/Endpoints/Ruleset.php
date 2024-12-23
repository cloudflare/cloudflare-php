<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Ruleset implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get all rulesets for a zone.
     *
     * @param string $zoneID The ID of the zone.
     * @return array The list of rulesets.
     */
    public function listZoneRulesets(string $zoneID): array
    {
        $response = $this->adapter->get("zones/{$zoneID}/rulesets");

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        return $data["result"] ?? [];
    }

    /**
     * Get rulesets for a specific phase within a zone.
     *
     * @param string $zoneID The ID of the zone.
     * @param string $phase The phase of the ruleset (e.g., http_request_dynamic_redirect).
     * @return array The filtered list of rulesets.
     */
    public function getRulesetsByPhase(string $zoneID, string $phase): array
    {
        $rulesets = $this->listZoneRulesets($zoneID);
        return array_filter($rulesets, function ($ruleset) use ($phase) {
            return isset($ruleset['phase']) && $ruleset['phase'] === $phase;
        });
    }

    /**
     * Get a specific ruleset by ID.
     *
     * @param string $zoneID The ID of the zone.
     * @param string $rulesetID The ID of the ruleset.
     * @return array The ruleset details.
     */
    public function getRuleset(string $zoneID, string $rulesetID): array
    {
        $response = $this->adapter->get("zones/{$zoneID}/rulesets/{$rulesetID}");

        $body = $response->getBody()->getContents();

        $data = json_decode($body, true);

        return $data["result"] ?? [];
    }

    /**
     * Create a new ruleset for a zone.
     *
     * @param string $zoneID The ID of the zone.
     * @param array $payload The payload for the new ruleset.
     * @return array The created ruleset details.
     */
    public function createRuleset(string $zoneID, array $payload): array
    {
        $response = $this->adapter->post("zones/{$zoneID}/rulesets", $payload);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        return $data["result"] ?? [];
    }

    /**
     * Update an existing ruleset.
     *
     * @param string $zoneID The ID of the zone.
     * @param string $rulesetID The ID of the ruleset.
     * @param array $payload The payload with updated ruleset details.
     * @return array The updated ruleset details.
     */
    public function updateRuleset(string $zoneID, string $rulesetID, array $payload): array
    {
        $response = $this->adapter->put("zones/{$zoneID}/rulesets/{$rulesetID}", $payload);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        return $data["result"] ?? [];
    }

    /**
     * Delete a specific rule by name from a ruleset.
     *
     * @param string $zoneID The ID of the zone.
     * @param string $rulesetID The ID of the ruleset.
     * @param string $ruleName The name of the rule to delete.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteRuleByName(string $zoneID, string $rulesetID, string $ruleName): bool
    {
        $rulesetDetails = $this->getRuleset($zoneID, $rulesetID);
        $rules = $rulesetDetails['rules'] ?? [];

        // Filter out the rule with the specified name
        $updatedRules = array_filter($rules, function ($rule) use ($ruleName) {
            return $rule['description'] !== $ruleName;
        });

        if (count($updatedRules) === count($rules)) {
            // No rule was removed
            return false;
        }

        $payload = ['rules' => array_values($updatedRules)];
        $updatedRuleset = $this->updateRuleset($zoneID, $rulesetID, $payload);

        return !empty($updatedRuleset);
    }

    /**
     * Delete a ruleset from a zone.
     *
     * @param string $zoneID The ID of the zone.
     * @param string $rulesetID The ID of the ruleset.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteRuleset(string $zoneID, string $rulesetID): bool
    {
        $response = $this->adapter->delete("zones/{$zoneID}/rulesets/{$rulesetID}");

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        return $data["success"] ?? false;
    }
}
