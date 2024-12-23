<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Ruleset;
use PHPUnit\Framework\TestCase;

class RulesetTest extends TestCase
{
    private $adapterMock;
    private $ruleset;

    protected function setUp(): void
    {
        $this->adapterMock = $this->createMock(Adapter::class);
        $this->ruleset = new Ruleset($this->adapterMock);
    }

    public function testListZoneRulesets(): void
    {
        $zoneID = 'example-zone-id';
        $expectedResult = [
            'result' => [
                [
                    'id' => 'example-ruleset-id',
                    'name' => 'Example Ruleset',
                    'phase' => 'http_request_dynamic_redirect',
                ],
            ],
        ];

        $this->adapterMock->expects($this->once())
            ->method('get')
            ->with("zones/{$zoneID}/rulesets")
            ->willReturn($this->createResponseMock($expectedResult));

        $result = $this->ruleset->listZoneRulesets($zoneID);

        $this->assertEquals($expectedResult['result'], $result);
    }

    public function testGetRulesetsByPhase(): void
    {
        $zoneID = 'example-zone-id';
        $phase = 'http_request_dynamic_redirect';
        $rulesets = [
            [
                'id' => 'example-ruleset-id',
                'name' => 'Example Ruleset',
                'phase' => $phase,
            ],
            [
                'id' => 'another-ruleset-id',
                'name' => 'Another Ruleset',
                'phase' => 'http_request_firewall',
            ],
        ];

        $this->adapterMock->expects($this->once())
            ->method('get')
            ->with("zones/{$zoneID}/rulesets")
            ->willReturn($this->createResponseMock(['result' => $rulesets]));

        $result = $this->ruleset->getRulesetsByPhase($zoneID, $phase);

        $this->assertCount(1, $result);
        $this->assertEquals($phase, $result[0]['phase']);
    }

    public function testCreateRuleset(): void
    {
        $zoneID = 'example-zone-id';
        $payload = [
            'name' => 'Test Ruleset',
            'description' => 'A ruleset for testing',
            'kind' => 'zone',
            'phase' => 'http_request_dynamic_redirect',
            'rules' => [],
        ];
        $expectedResult = ['id' => 'new-ruleset-id'];

        $this->adapterMock->expects($this->once())
            ->method('post')
            ->with("zones/{$zoneID}/rulesets", $payload)
            ->willReturn($this->createResponseMock(['result' => $expectedResult]));

        $result = $this->ruleset->createRuleset($zoneID, $payload);

        $this->assertEquals($expectedResult, $result);
    }

    public function testDeleteRuleByName(): void
    {
        $zoneID = 'example-zone-id';
        $rulesetID = 'example-ruleset-id';
        $ruleName = 'Example Rule';
        $rulesetDetails = [
            'rules' => [
                [
                    'description' => $ruleName,
                ],
                [
                    'description' => 'Another Rule',
                ],
            ],
        ];

        $updatedRuleset = [
            'rules' => [
                [
                    'description' => 'Another Rule',
                ],
            ],
        ];

        $this->adapterMock->expects($this->once())
            ->method('get')
            ->with("zones/{$zoneID}/rulesets/{$rulesetID}")
            ->willReturn($this->createResponseMock(['result' => $rulesetDetails]));

        $this->adapterMock->expects($this->once())
            ->method('put')
            ->with("zones/{$zoneID}/rulesets/{$rulesetID}", ['rules' => $updatedRuleset['rules']])
            ->willReturn($this->createResponseMock(['result' => $updatedRuleset]));

        $result = $this->ruleset->deleteRuleByName($zoneID, $rulesetID, $ruleName);

        $this->assertTrue($result);
    }

    private function createResponseMock(array $body): object
    {
        $responseMock = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($this->createStreamMock(json_encode($body)));
        return $responseMock;
    }

    private function createStreamMock(string $content): object
    {
        $streamMock = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $streamMock->method('getContents')->willReturn($content);
        return $streamMock;
    }
}
