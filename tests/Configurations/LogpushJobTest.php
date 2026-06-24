<?php

use PHPUnit\Framework\TestCase;
use Cloudflare\API\Configurations\LogpushJob;

class LogpushJobTest extends TestCase
{
    public function testGetArray()
    {
        $logpushJob = new LogpushJob();
        $logpushJob->setName('example.com');
        $logpushJob->setDestinationConf('s3://mybucket/logs?region=us-west-2');
        $logpushJob->setOwnershipChallenge('00000000000000000000');
        $logpushJob->setDisabled();
        $logpushJob->setDataset('http_requests');
        $logpushJob->setLogpullOptions('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339');
        $logpushJob->setFrequency('high');

        $array = $logpushJob->getArray();
        $this->assertEquals('example.com', $array['name']);
        $this->assertEquals('s3://mybucket/logs?region=us-west-2', $array['destination_conf']);
        $this->assertEquals('00000000000000000000', $array['ownership_challenge']);
        $this->assertFalse($array['enabled']);
        $this->assertEquals('http_requests', $array['dataset']);
        $this->assertEquals('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339', $array['logpull_options']);
        $this->assertEquals('high', $array['frequency']);
    }
}
