<?php
/**
 * Created by PhpStorm.
 * User: Jens Beltofte
 * Date: 15/04/2021
 * Time: 11:35
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\LogpushJob as Configs;

class LogpushJobs implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function listLogpushJobs(
        string $zoneID,
        string $dataset = null
    ): \stdClass {
        $endpoint = 'zones/' . $zoneID . '/logpush/jobs';

        if ($dataset) {
            $endpoint = 'zones/' . $zoneID . '/logpush/datasets/' . $dataset .'/jobs';
        }

        $jobs = $this->adapter->get($endpoint);

        $body = json_decode($jobs->getBody());

        return (object)['result' => $body->result];
    }

    public function listFields(
        string $zoneID,
        string $dataset
    ): \stdClass {
        $endpoint = 'zones/' . $zoneID . '/logpush/datasets/' . $dataset . '/fields';

        $fields = $this->adapter->get($endpoint);

        $body = json_decode($fields->getBody());

        return (object)['result' => $body->result];
    }

    public function getOwnershipChallenge(
        string $zoneID,
        string $destinationConf
    ): \stdClass {
        $options = new Configs();
        $options->setDestinationConf($destinationConf);

        $endpoint = 'zones/' . $zoneID . '/logpush/ownership';

        $ownership = $this->adapter->post($endpoint, $options->getArray());

        $body = json_decode($ownership->getBody());

        return (object)['result' => $body->result];
    }

    public function validateOwnershipChallenge(
        string $zoneID,
        string $destinationConf,
        string $ownershipChallenge
    ): bool {
        $options = new Configs();
        $options->setDestinationConf($destinationConf);
        $options->setOwnershipChallenge($ownershipChallenge);

        $endpoint = 'zones/' . $zoneID . '/logpush/ownership/validate';

        $validate = $this->adapter->post($endpoint, $options->getArray());

        $body = json_decode($validate->getBody());

        if (isset($body->result->valid)) {
            return $body->result->valid;
        }

        return false;
    }

    public function validateOrigin(
        string $zoneID,
        string $logpullOptions
    ): bool {
        $options = new Configs();
        $options->setLogpullOptions($logpullOptions);

        $endpoint = 'zones/' . $zoneID . '/logpush/validate/origin';

        $validate = $this->adapter->post($endpoint, $options->getArray());

        $body = json_decode($validate->getBody());

        if (isset($body->result->valid)) {
            return $body->result->valid;
        }

        return false;
    }

    public function createLogpushJob(
        string $zoneID,
        string $destinationConf,
        string $ownershipChallenge,
        string $name = '',
        bool $status = null,
        string $dataset = '',
        string $logpullOptions = '',
        string $frequency = ''
    ):  \stdClass {
        $options = new Configs();
        $options->setDestinationConf($destinationConf);
        $options->setOwnershipChallenge($ownershipChallenge);
        $options->setName($name);
        $status == true ? $options->setEnabled() : $options->setDisabled();
        $options->setDataset($dataset);
        $options->setLogpullOptions($logpullOptions);
        $options->setFrequency($frequency);

        $endpoint = 'zones/' . $zoneID . '/logpush/jobs';

        $job = $this->adapter->post($endpoint, $options->getArray());

        $body = json_decode($job->getBody());

        return (object)['result' => $body->result];
    }

    public function getLogpushJob(
        string $zoneID,
        int $jobId
    ):  \stdClass {
        $endpoint = 'zones/' . $zoneID . '/logpush/jobs/' . $jobId;

        $job = $this->adapter->get($endpoint);

        $body = json_decode($job->getBody());

        return (object)['result' => $body->result];
    }

    public function updateLogpushJob(
        string $zoneID,
        int $jobId,
        string $destinationConf = '',
        string $ownershipChallenge = '',
        bool $status = null,
        string $logpullOptions = '',
        string $frequency = ''
    ):  \stdClass {
        $options = new Configs();
        $options->setDestinationConf($destinationConf);
        $options->setOwnershipChallenge($ownershipChallenge);
        $status == true ? $options->setEnabled() : $options->setDisabled();
        $options->setLogpullOptions($logpullOptions);
        $options->setFrequency($frequency);

        $endpoint = 'zones/' . $zoneID . '/logpush/jobs/' . $jobId;

        $job = $this->adapter->put($endpoint, $options->getArray());

        $body = json_decode($job->getBody());

        return (object)['result' => $body->result];
    }

    public function deleteLogpushJob(
        string $zoneID,
        int $jobId
    ):  bool {
        $endpoint = 'zones/' . $zoneID . '/logpush/jobs/' . $jobId;

        $job = $this->adapter->delete($endpoint);

        $body = json_decode($job->getBody());

        return $body->success;
    }

    public function checkDestinationExists(
        string $zoneID,
        string $destinationConf
    ): bool {
        $options = new Configs();
        $options->setDestinationConf($destinationConf);

        $endpoint = 'zones/' . $zoneID . '/logpush/validate/destination/exists';

        $check = $this->adapter->post($endpoint, $options->getArray());

        $body = json_decode($check->getBody());

        if (isset($body->result->exists)) {
            return $body->result->exists;
        }

        return false;
    }
}
