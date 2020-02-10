<?php

/**
 * Created by Visual Studio Code.
 * User: elliot.alderson
 * Date: 10/02/2020
 * Time: 04:28 AM
 */
class DNSAnalyticsTest extends TestCase
{
    public function testGetDNSAnalyticsReportTable()
    {
        $response = $this->getPsr7JsonResponseForFixture(
            'Endpoints/getDNSAnalyticsReportTable.json'
        );

        $mock = $this->getMockBuilder(
            \Cloudflare\API\Adapter\Adapter::class
        )->getMock();
        $mock->method('get')->willReturn($response);

        $mock
            ->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(
                    'zones/023e105f4ecef8ad9ca31a8372d0c353/dns_analytics/report'
                )
            );

        $analytics = new \Cloudflare\API\Endpoints\DNSAnalytics($mock);
        $since = '2020-02-01T00:00:00Z';
        $until = '2020-02-28T23:59:59Z';
        $filters = 'responseCode==NOERROR AND queryType==A';

        $result = $analytics->getReportTable(
            '023e105f4ecef8ad9ca31a8372d0c353',
            ['queryName', 'queryType', 'responseCode'],
            ['queryCount'],
            ['-queryCount'],
            $filters,
            $since,
            $until
        );

        $this->assertEquals(1, $result->rows);
        $this->assertEquals($since, $result->query->since);
        $this->assertEquals($until, $result->query->until);
    }

    public function testGetDNSAnalyticsReportByTime()
    {
        $response = $this->getPsr7JsonResponseForFixture(
            'Endpoints/getDNSAnalyticsReportByTime.json'
        );

        $mock = $this->getMockBuilder(
            \Cloudflare\API\Adapter\Adapter::class
        )->getMock();
        $mock->method('get')->willReturn($response);

        $mock
            ->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(
                    'zones/023e105f4ecef8ad9ca31a8372d0c353/dns_analytics/report/bytime'
                )
            );

        $analytics = new \Cloudflare\API\Endpoints\DNSAnalytics($mock);
        $since = '2020-02-01T00:00:00Z';
        $until = '2020-02-28T23:59:59Z';
        $filters = 'responseCode==NOERROR AND queryType==A';

        $result = $analytics->getReportByTime(
            '023e105f4ecef8ad9ca31a8372d0c353',
            ['queryName', 'queryType', 'responseCode'],
            ['queryCount'],
            ['-queryCount'],
            $filters,
            $since,
            $until,
            2
        );

        $this->assertEquals(2, $result->rows);
        $this->assertEquals($since, $result->query->since);
        $this->assertEquals($until, $result->query->until);
    }
}
