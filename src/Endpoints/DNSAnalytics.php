<?php
/**
 * Created by Visual Studio Code.
 * User: elliot.alderson
 * Date: 2020-02-06
 * Time: 03:40 AM
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use Cloudflare\API\Configurations\DNSAnalytics as Configs;

class DNSAnalytics implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Retrieves a list of summarised aggregate metrics over a given time period.
     *
     * @param string $zoneID ID of zone to get report for
     * @param string $dimensions Comma separated names of dimensions
     * @param string $metrics Comma separated names of dimension to get metrics for
     * @param string $sort Comma separated names of dimension to sort by prefixed by order - (descending) or + (ascending)
     * @param string $filters Segmentation filter in 'attribute operator value' format
     * @param string $since Start date and time of requesting data period in the ISO8601 format
     * @param string $until End date and time of requesting data period in the ISO8601 format
     * @param string $limit Limit number of returned metrics
     * @return array
     */
    public function getReportTable(
        string $zoneID,
        array $dimensions = [],
        array $metrics = [],
        array $sort = [],
        string $filters = '',
        string $since = '',
        string $until = '',
        int $limit = 100
    ): \stdClass {
        if (count($dimensions) === 0) {
            throw new EndpointException(
                'At least one dimension is required for getting a report.'
            );
        }

        if (count($metrics) === 0) {
            throw new EndpointException(
                'At least one metric is required for getting a report.'
            );
        }

        if (!$since) {
            throw new EndpointException(
                'Start date is required for getting a report.'
            );
        }

        if (!$until) {
            throw new EndpointException(
                'End date is required for getting a report.'
            );
        }

        $options = [
            'dimensions' => implode(',', $dimensions),
            'metrics' => implode(',', $metrics),
            'since' => $since,
            'until' => $until
        ];

        if (count($sort) !== 0) {
            $options['sort'] = implode(',', $sort);
        }

        if ($filters) {
            $options['filters'] = $filters;
        }

        if ($limit) {
            $options['limit'] = $limit;
        }

        $endpoint = 'zones/' . $zoneID . '/dns_analytics/report';

        $report = $this->adapter->get($endpoint, $options);

        $this->body = json_decode($report->getBody());

        return $this->body->result;
    }

    /**
     * Retrieves a list of aggregate metrics grouped by time interval.
     *
     * @param string $zoneID ID of zone to get report for
     * @param string $dimensions Comma separated names of dimensions
     * @param string $metrics Comma separated names of dimension to get metrics for
     * @param string $sort Comma separated names of dimension to sort by prefixed by order - (descending) or + (ascending)
     * @param string $filters Segmentation filter in 'attribute operator value' format
     * @param string $since Start date and time of requesting data period in the ISO8601 format
     * @param string $until End date and time of requesting data period in the ISO8601 format
     * @param string $limit Limit number of returned metrics
     * @param string $timeDelta Unit of time to group data by
     * @return array
     */
    public function getReportByTime(
        string $zoneID,
        array $dimensions = [],
        array $metrics = [],
        array $sort = [],
        string $filters = '',
        string $since = '',
        string $until = '',
        int $limit = 100,
        string $timeDelta = ''
    ): \stdClass {
        $options = new Configs();
        $options->setDimensions($dimensions);
        $options->setMetrics($metrics);
        $options->setSince($since);
        $options->setUntil($until);
        $options->setSorting($sort);
        $options->setFilters($filters);
        $options->setLimit($limit);
        $options->setTimeDelta($timeDelta);

        $endpoint = 'zones/' . $zoneID . '/dns_analytics/report/bytime';

        $report = $this->adapter->get($endpoint, $options->getArray());

        $this->body = json_decode($report->getBody());

        return $this->body->result;
    }
}
