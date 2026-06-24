<?php
/**
 * Created by PhpStorm.
 * User: Jens Beltofte
 * Date: 15/04/2021
 * Time: 12:58
 */

namespace Cloudflare\API\Configurations;

class LogpushJob implements Configurations
{
    private $configs = [];

    public function setDestinationConf(string $destinationConf)
    {
        if ($destinationConf) {
            $this->configs['destination_conf'] = $destinationConf;
        }
    }

    public function setOwnershipChallenge(string $ownershipChallenge)
    {
        if ($ownershipChallenge) {
            $this->configs['ownership_challenge'] = $ownershipChallenge;
        }
    }

    public function setLogpullOptions(string $logpullOptions)
    {
        if ($logpullOptions) {
            $this->configs['logpull_options'] = $logpullOptions;
        }
    }

    public function setName(string $name)
    {
        if ($name) {
            $this->configs['name'] = $name;
        }
    }

    public function setEnabled()
    {
        $this->configs['enabled'] = true;
    }

    public function setDisabled()
    {
        $this->configs['enabled'] = false;
    }

    public function setDataset(string $dataset)
    {
        if ($dataset) {
            $this->configs['dataset'] = $dataset;
        }
    }

    public function setFrequency(string $frequency)
    {
        if ($frequency) {
            $this->configs['frequency'] = $frequency;
        }
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
