<?php

namespace Cloudflare\API\Configurations;

class DNSAnalytics implements Configurations
{
    protected $configs = [];

    public function getArray(): array
    {
        return $this->configs;
    }

    public function setDimensions(array $dimensions)
    {
        if (count($dimensions) !== 0) {
            $this->configs['dimensions'] = implode(',', $dimensions);
        }
    }

    public function setMetrics(array $metrics)
    {
        if (count($metrics) !== 0) {
            $this->configs['metrics'] = implode(',', $metrics);
        }
    }

    public function setSince(string $since)
    {
        if ($since) {
            $this->configs['since'] = $since;
        }
    }

    public function setUntil(string $until)
    {
        if ($until) {
            $this->configs['until'] = $until;
        }
    }

    public function setSorting(array $sorting)
    {
        if (count($sorting) !== 0) {
            $this->configs['sort'] = implode(',', $sorting);
        }
    }

    public function setFilters(string $filters)
    {
        if ($filters) {
            $this->configs['filters'] = $filters;
        }
    }

    public function setLimit(int $limit)
    {
        if ($limit) {
            $this->configs['limit'] = $limit;
        }
    }

    public function setTimeDelta(string $timeDelta)
    {
        if ($timeDelta) {
            $this->configs['time_delta'] = $timeDelta;
        }
    }
}
