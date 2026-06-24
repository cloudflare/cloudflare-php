<?php

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\LogpushJobs;
use Cloudflare\API\Configurations\LogpushJob as Config;

class LogpushJobsTest extends TestCase
{
    public function testListLogpushJobs()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listLogpushJobs.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/jobs')
            );

        $logpushMock = new LogpushJobs($mock);
        $result = $logpushMock->listLogpushJobs('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertEquals(1, $result->result[0]->id);
    }

    public function testListFields()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listFields.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/datasets/http_requests/fields')
            );

        $logpushMock = new LogpushJobs($mock);
        $result = $logpushMock->listFields('023e105f4ecef8ad9ca31a8372d0c353', 'http_requests');

        $this->assertTrue(!empty($result->result->ClientASN));
    }

    public function testGetOwnershipChallenge()
    {
        $config = new Config();
        $config->setDestinationConf('s3://mybucket/logs?region=us-west-2');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOwnershipChallenge.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/ownership'),
                $this->equalTo(
                    $config->getArray()
                )
            );

        $logpushMock = new LogpushJobs($mock);
        $result = $logpushMock->getOwnershipChallenge('023e105f4ecef8ad9ca31a8372d0c353', 's3://mybucket/logs?region=us-west-2');

        $this->assertEquals('logs/challenge-filename.txt', $result->result->filename);
        $this->assertTrue($result->result->valid);
    }

    public function testValidateOwnershipChallenge()
    {
        $config = new Config();
        $config->setDestinationConf('s3://mybucket/logs?region=us-west-2');
        $config->setOwnershipChallenge('00000000000000000000');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/validateOwnershipChallenge.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/ownership/validate'),
                $this->equalTo(
                    $config->getArray()
                )
            );

        $logpushMock = new LogpushJobs($mock);
        $arguments = $config->getArray();
        $result = $logpushMock->validateOwnershipChallenge(
            '023e105f4ecef8ad9ca31a8372d0c353',
            $arguments['destination_conf'],
            $arguments['ownership_challenge']
        );

        $this->assertTrue($result);
    }

    public function testValidateOrigin()
    {
        $config = new Config();
        $config->setLogpullOptions('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/validateOrigin.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/validate/origin'),
                $this->equalTo(
                    $config->getArray()
                )
            );

        $logpushMock = new LogpushJobs($mock);
        $arguments = $config->getArray();
        $result = $logpushMock->validateOrigin(
            '023e105f4ecef8ad9ca31a8372d0c353',
            $arguments['logpull_options']
        );

        $this->assertTrue($result);
    }

    public function testCreateLogpushJob()
    {
        $config = new Config();
        $config->setDestinationConf('s3://mybucket/logs?region=us-west-2');
        $config->setOwnershipChallenge('00000000000000000000');
        $config->setName('example.com');
        $config->setDisabled();
        $config->setDataset('http_requests');
        $config->setLogpullOptions('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339');
        $config->setFrequency('high');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createLogpushJob.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/jobs'),
                $this->equalTo(
                    $config->getArray()
                )
            );

        $logpushMock = new LogpushJobs($mock);
        $arguments = $config->getArray();
        $result = $logpushMock->createLogpushJob(
            '023e105f4ecef8ad9ca31a8372d0c353',
            $arguments['destination_conf'],
            $arguments['ownership_challenge'],
            $arguments['name'],
            $arguments['enabled'],
            $arguments['dataset'],
            $arguments['logpull_options'],
            $arguments['frequency']
        );

        $this->assertFalse($result->result->enabled);
        $this->assertEquals('example.com', $result->result->name);
        $this->assertEquals('http_requests', $result->result->dataset);
        $this->assertEquals('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339', $result->result->logpull_options);
        $this->assertEquals('s3://mybucket/logs?region=us-west-2', $result->result->destination_conf);
        $this->assertEquals('high', $result->result->frequency);
    }

    public function testGetLogpushJob()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getLogpushJob.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/jobs/1')
            );

        $logpushMock = new LogpushJobs($mock);
        $result = $logpushMock->getLogpushJob(
            '023e105f4ecef8ad9ca31a8372d0c353',
            1
        );

        $this->assertFalse($result->result->enabled);
        $this->assertEquals('example.com', $result->result->name);
        $this->assertEquals('http_requests', $result->result->dataset);
        $this->assertEquals('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339', $result->result->logpull_options);
        $this->assertEquals('s3://mybucket/logs?region=us-west-2', $result->result->destination_conf);
        $this->assertEquals('high', $result->result->frequency);
    }

    public function testUpdateLogpushJob()
    {
        $config = new Config();
        $config->setDestinationConf('s3://mybucket/logs?region=us-west-2');
        $config->setOwnershipChallenge('00000000000000000000');
        $config->setDisabled();
        $config->setLogpullOptions('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339');
        $config->setFrequency('high');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateLogpushJob.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('put')->willReturn($response);

        $mock->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/jobs/1'),
                $this->equalTo(
                    $config->getArray()
                )
            );

        $logpushMock = new LogpushJobs($mock);
        $arguments = $config->getArray();
        $result = $logpushMock->updateLogpushJob(
            '023e105f4ecef8ad9ca31a8372d0c353',
            1,
            $arguments['destination_conf'],
            $arguments['ownership_challenge'],
            $arguments['enabled'],
            $arguments['logpull_options'],
            $arguments['frequency']
        );

        $this->assertFalse($result->result->enabled);
        $this->assertEquals('fields=RayID,ClientIP,EdgeStartTimestamp&timestamps=rfc3339', $result->result->logpull_options);
        $this->assertEquals('s3://mybucket/logs?region=us-west-2', $result->result->destination_conf);
        $this->assertEquals('high', $result->result->frequency);
    }

    public function testDeleteLogpushJob()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteLogpushJob.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/jobs/1')
            );

        $logpushMock = new LogpushJobs($mock);
        $result = $logpushMock->deleteLogpushJob(
            '023e105f4ecef8ad9ca31a8372d0c353',
            1
        );

        $this->assertTrue($result);
    }

    public function testCheckDestinationExists()
    {
        $config = new Config();
        $config->setDestinationConf('s3://mybucket/logs?region=us-west-2');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/checkDestinationExists.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/logpush/validate/destination/exists'),
                $config->getArray()
            );

        $logpushMock = new LogpushJobs($mock);
        $arguments = $config->getArray();
        $result = $logpushMock->checkDestinationExists(
            '023e105f4ecef8ad9ca31a8372d0c353',
            $arguments['destination_conf']
        );

        $this->assertFalse($result);
    }
}
