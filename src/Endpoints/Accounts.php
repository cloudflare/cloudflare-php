<?php
/**
 * User: kanasite
 * Date: 01/28/2019
 * Time: 10:00
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Accounts implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addAccount(string $name, string $type = 'standard'): \stdClass
    {
        $options = [
            'name' => $name,
            'type' => $type,
        ];

        $account = $this->adapter->post('accounts', $options);
        $this->body = json_decode($account->getBody());

        return $this->body->result;
    }

    public function updateAccount(
        string $accountID,
        string $name = null,
        bool $enforceTwofactor = null,
        bool $useAccountCustomNsByDefault = null
    ): \stdClass {
        $data = [
            'id' => $accountID
        ];

        if ($name !== null) {
            $data['name'] = $name;
        }

        if ($enforceTwofactor !== null) {
            $data['settings']['enforce_twofactor'] = $enforceTwofactor;
        }

        if ($useAccountCustomNsByDefault !== null) {
            $data['settings']['use_account_custom_ns_by_default'] = $useAccountCustomNsByDefault;
        }

        $query = $this->adapter->put('accounts/' . $accountID, $data);
        $this->body = json_decode($query->getBody());

        return $this->body->result;
    }

    public function listAccounts(
        int $page = 1,
        int $perPage = 20,
        string $direction = ''
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage
        ];

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('accounts', $query);
        $this->body = json_decode($user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getDomains(string $accountID): array
    {
        $response = $this->adapter->get('accounts/' . $accountID . '/registrar/domains');

        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function getDomainDetails(string $accountID, string $domainName): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountID . '/registrar/domains/' . $domainName);

        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function lockDomain(string $accountID, string $domainName): \stdClass
    {
        $response = $this->adapter->put('accounts/' . $accountID . '/registrar/domains/' . $domainName, ['locked' => true]);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }

    public function unlockDomain(string $accountID, string $domainName): \stdClass
    {
        $response = $this->adapter->put('accounts/' . $accountID . '/registrar/domains/' . $domainName, ['locked' => false]);
        $this->body = json_decode($response->getBody());
        return $this->body;
    }
}
