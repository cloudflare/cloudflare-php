<?php
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

use Cloudflare\API\Configurations\ConfigurationsException;
use Cloudflare\API\Configurations\Pool;

class PoolTest extends TestCase
{
    /**
     * @dataProvider testArgumentsDataProvider
     */
    public function testArguments($setFunction, $arguments, $getFunction, $invalid)
    {
        $pool = new Pool('bogus', []);
        foreach ($arguments as $argument) {
            if ($invalid) {
                try {
                    $pool->{$setFunction}($argument);
                } catch (ConfigurationsException $e) {
                    $this->assertNotEquals($argument, $pool->{$getFunction}());
                }
            } elseif ($invalid === false) {
                $pool->{$setFunction}($argument);
                $this->assertEquals($argument, $pool->{$getFunction}());
            }
        }
    }

    public function testArgumentsDataProvider()
    {
        return [
            'origins arguments valid' => [
                'setOrigins', [[['name' => 'test', 'address' => 'server1.example.com']]], 'getOrigins', false
            ],
            'setNotificationEmail arguments valid' => [
                'setNotificationEmail', ['user@example.com'], 'getNotificationEmail', false
            ],
            'origins arguments invalid no address' => [
                'setOrigins', [['name' => 'test']], 'getOrigins', true
            ],
            'origins arguments invalid no name' => [
                'setOrigins', [['address' => 'server1.example.com']], 'getOrigins', true
            ],
            'setNotificationEmail arguments invalid' => [
                'setNotificationEmail', ['userexample.com'], 'getNotificationEmail', true
            ]
        ];
    }
}
