<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

use Cloudflare\API\Configurations\ConfigurationsException;
use Cloudflare\API\Configurations\LoadBalancer;

class LoadBalancerTest extends TestCase
{
    /**
     * @dataProvider testArgumentsDataProvider
     */
    public function testArguments($setFunction, $arguments, $getFunction, $invalid)
    {
        $lb = new LoadBalancer('bous', [], 'bogus');
        foreach ($arguments as $argument) {
            if ($invalid) {
                try {
                    $lb->{$setFunction}($argument);
                } catch (ConfigurationsException $e) {
                    $this->assertNotEquals($argument, $lb->{$getFunction}());
                }
            } else {
                $lb->{$setFunction}($argument);
                $this->assertEquals($argument, $lb->{$getFunction}());
            }

        }
    }

    public function testArgumentsDataProvider()
    {
        return [
            'steeringPolicy arguments valid' => [
                'setSteeringPolicy', ['off', 'geo', 'random', 'dynamic_latency', ''], 'getSteeringPolicy', false
            ],
            'sessionAffinity arguments valid' => [
                'setSessionAffinity', ['none', 'cookie', 'ip_cookie', ''], 'getSessionAffinity', false
            ],
            'sessionAffinityTtl arguments valid' => [
                'setSessionAffinityTtl', [3600], 'getSessionAffinityTtl', false
            ],
            'steeringPolicy arguments invalid' => [
                'setSteeringPolicy', ['invalid'], 'getSteeringPolicy', true
            ],
            'sessionAffinity arguments invalid' => [
                'setSessionAffinity', ['invalid'], 'getSessionAffinity', true
            ],
            'sessionAffinityTtl arguments invalid' => [
                'setSessionAffinityTtl', [1337], 'getSessionAffinityTtl', true
            ],
        ];
    }
}
