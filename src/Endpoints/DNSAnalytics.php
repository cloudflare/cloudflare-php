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

class DNSAnalytics implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * @param string $zoneID ID of zone to get report for
     * @param string $dimensions Comma separated names of dimensions
     * @param string $metrics Comma separated names of dimension to get metrics for
     * @param string $sort Comma separated names of dimension to sort by prefixed by order - (descending) or + (ascending)
     * @param string $filters Segmentation filter in 'attribute operator value' format
     * @param string $since Start date and time of requesting data period in the ISO8601 format
     * @param string $until End date and time of requesting data period in the ISO8601 format
     * @return array
     */
    public function getReport(
        string $zoneID,
        string $dimensions,
        string $metrics,
        string $sort,
        string $filters,
        string $since,
        string $until
    ): array {
        $options = [
            'dimensions' => $dimensions,
            'metrics' => $metrics,
            'sort' => $sort,
            'filters' => $filters,
            'since' => $since,
            'until' => $until
        ];

        $endpoint = 'zones/' . $zoneID . '/dns_analytics/report';

        $report = $this->adapter->get($endpoint, $options);

        $this->body = json_decode($report->getBody());

        return $this->body->result->data;
    }
}
