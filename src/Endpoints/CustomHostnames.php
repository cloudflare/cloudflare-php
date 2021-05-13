<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 18/03/2018
 * Time: 21:46
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class CustomHostnames implements API
{
    use BodyAccessorTrait;
    
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }


    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $zoneID
     * @param string $hostname
     * @param string $sslMethod
     * @param string $sslType
     * @param array $sslSettings
     * @param string $customOriginServer
     * @param bool $wildcard
     * @return \stdClass
     */
    public function addHostname(string $zoneID, string $hostname, string $sslMethod = 'http', string $sslType = 'dv', array $sslSettings = [], string $customOriginServer = '', bool $wildcard = false): \stdClass
    {
        $options = [
            'hostname' => $hostname,
            'ssl' => [
                'method' => $sslMethod,
                'type' => $sslType,
                'settings' => $sslSettings
            ],
            'wildcard' => $wildcard,
        ];

        if (!empty($customOriginServer)) {
            $options['custom_origin_server'] = $customOriginServer;
        }

        $zone = $this->adapter->post('zones/'.$zoneID.'/custom_hostnames', $options);
        $this->body = json_decode($zone->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $hostname
     * @param string $id
     * @param int $page
     * @param int $perPage
     * @param string $order
     * @param string $direction
     * @param int $ssl
     * @return \stdClass
     */
    public function listHostnames(
        string $zoneID,
        string $hostname = '',
        string $hostnameID = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = '',
        int $ssl = 0
    ): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'ssl' => $ssl
        ];

        if (!empty($hostname)) {
            $query['hostname'] = $hostname;
        }

        if (!empty($hostnameID)) {
            $query['id'] = $hostnameID;
        }

        if (!empty($order)) {
            $query['order'] = $order;
        }

        if (!empty($direction)) {
            $query['direction'] = $direction;
        }

        $zone = $this->adapter->get('zones/'.$zoneID.'/custom_hostnames', $query);
        $this->body = json_decode($zone->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    /**
     * @param string $zoneID
     * @param string $hostnameID
     * @return mixed
     */
    public function getHostname(string $zoneID, string $hostnameID)
    {
        $zone = $this->adapter->get('zones/'.$zoneID.'/custom_hostnames/'.$hostnameID);
        $this->body = json_decode($zone->getBody());

        return $this->body->result;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $zoneID
     * @param string $hostnameID
     * @param string $sslMethod
     * @param string $sslType
     * @return \stdClass
     */
    public function updateHostname(string $zoneID, string $hostnameID, string $sslMethod = '', string $sslType = '', array $sslSettings = [], string $customOriginServer = ''): \stdClass
    {
        $query = [];

        if (!empty($sslMethod)) {
            $query['method'] = $sslMethod;
        }

        if (!empty($sslType)) {
            $query['type'] = $sslType;
        }

        if (!empty($sslSettings)) {
            $query['settings'] = $sslSettings;
        }

        if (!empty($query)) {
            $options = [
                'ssl' => $query
            ];
        }

        if (!empty($customOriginServer)) {
            $options['custom_origin_server'] = $customOriginServer;
        }

        $zone = $this->adapter->patch('zones/'.$zoneID.'/custom_hostnames/'.$hostnameID, $options);
        $this->body = json_decode($zone->getBody());
        return $this->body->result;
    }

    /**
     * @param string $zoneID
     * @param string $hostnameID
     * @return \stdClass
     */
    public function deleteHostname(string $zoneID, string $hostnameID): \stdClass
    {
        $zone = $this->adapter->delete('zones/'.$zoneID.'/custom_hostnames/'.$hostnameID);
        $this->body = json_decode($zone->getBody());
        return $this->body;
    }
}
