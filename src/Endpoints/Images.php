<?php
/**
 * Created by VSCode.
 * User: Cristiano Soares <crisnao2>
 * Date: 05/11/2022
 * Time: 22:36
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class Images implements API
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
     * @param string $accountId
     * @param string $fileOrUrl The path to the file or URL to image
     * @param string $id
     * @param bool $requireSignedURLs
     * @param array $metadata
     * @return object
     */
    public function uploadImage(
        string $accountId,
        string $fileOrUrl,
        string $id = '',
        bool $requireSignedURLs = false,
        array $metadata = []
    ): \stdClass {
        if (filter_var($fileOrUrl, FILTER_VALIDATE_URL)) {
            $data = [
                [
                    'name' => 'url',
                    'contents' => $fileOrUrl,
                ]
            ];
        } else {
            $data = [
                [
                    'name' => 'file',
                    'contents' => file_get_contents($fileOrUrl),
                    'filename' => basename($fileOrUrl),
                ]
            ];
        }

        if (!empty($id)) {
            $data[] = [
                'name' => 'id',
                'contents' => $id,
            ];
        }

        if ($requireSignedURLs) {
            $data[] = [
                'name' => 'requireSignedURLs',
                'contents' => $requireSignedURLs,
            ];
        }

        if ($metadata) {
            $data[] = [
                'name' => 'metadata',
                'contents' => json_encode($metadata),
            ];
        }

        $response = $this->adapter->post('accounts/' . $accountId . '/images/v1', $data, [], true);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param integer $page
     * @param integer $perPage
     * @return object
     */
    public function listImages(string $accountId, int $page = 1, int $perPage = 20): \stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
        ];

        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1', $query);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param string $imageId
     * @return string
     */
    public function getImageBlob(string $accountId, string $imageId): string
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/' . $imageId . '/blob');

        $this->body = $response->getBody();

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param string $imageId
     * @return object
     */
    public function getImageDetails(string $accountId, string $imageId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/' . $imageId);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $accountId
     * @param string $imageId
     * @param bool $requireSignedURLs
     * @param array $metadata
     * @return object
     */
    public function updateImage(
        string $accountId, 
        string $imageId, 
        bool $requireSignedURLs = false, 
        array $metadata = []
    ): \stdClass {
        $data = [
            'requireSignedURLs' => $requireSignedURLs,
            'metadata' => $metadata,
        ];

        $response = $this->adapter->patch('accounts/' . $accountId . '/images/v1/' . $imageId, $data);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param string $imageId
     * @return bool
     */
    public function deleteImage(string $accountId, string $imageId): bool
    {
        $response = $this->adapter->delete('accounts/' . $accountId . '/images/v1/' . $imageId);

        $this->body = json_decode($response->getBody());

        return $this->body->success && empty(get_object_vars($this->body->result));
    }

    /**
     * @param string $accountId
     * @return object
     */
    public function getStats(string $accountId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/stats');

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $accountId
     * @param string $imageId
     * @param bool $requireSignedURLs
     * @param array $metadata
     * @return object
     */
    public function addVariant(
        string $accountId, 
        string $variantId, 
        string $fit, 
        string $metadata, 
        int $width,
        int $height,
        bool $neverRequireSignedURLs = false
    ): \stdClass {
        $data = [
            'id' => $variantId,
            'options' => [
                'fit' => $fit,
                'metadata' => $metadata,
                'width' => $width,
                'height' => $height,
            ],
        ];

        if ($neverRequireSignedURLs) {
            $data['neverRequireSignedURLs'] = $neverRequireSignedURLs;
        }

        $response = $this->adapter->post('accounts/' . $accountId . '/images/v1/variants', $data);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @return object
     */
    public function listVariants(string $accountId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/variants');

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param string $variantId
     * @return object
     */
    public function getVariantDetails(string $accountId, string $variantId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/variants/' . $variantId);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string $accountId
     * @param string $variantId
     * @param string $fit
     * @param string $metadata
     * @param integer $width
     * @param integer $height
     * @param bool $neverRequireSignedURLs
     * @return object
     */
    public function updateVariant(
        string $accountId, 
        string $variantId, 
        string $fit, 
        string $metadata, 
        int $width,
        int $height,
        bool $neverRequireSignedURLs = false
    ): \stdClass {
        $data = [
            'options' => [
                'fit' => $fit,
                'metadata' => $metadata,
                'width' => $width,
                'height' => $height,
            ],
        ];

        $data['neverRequireSignedURLs'] = $neverRequireSignedURLs;

        $response = $this->adapter->patch('accounts/' . $accountId . '/images/v1/variants/' . $variantId, $data);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param bool $status
     * @return object
     */
    public function updateFlexibleVariantsStatus(
        string $accountId, 
        bool $status
    ): \stdClass {
        $data = [
            'flexible_variants' => $status
        ];

        $response = $this->adapter->patch('accounts/' . $accountId . '/images/v1/config', $data);

        $this->body = json_decode($response->getBody());

        return $this->body;
    }

    /**
     * @param string $accountId
     * @param string $variantId
     * @return bool
     */
    public function deleteVariant(string $accountId, string $variantId): bool
    {
        $response = $this->adapter->delete('accounts/' . $accountId . '/images/v1/variants/' . $variantId);

        $this->body = json_decode($response->getBody());

        return $this->body->success && empty(get_object_vars($this->body->result));
    }

    /**
     * @param string $accountId
     * @return object
     */
    public function listKeys(string $accountId): \stdClass
    {
        $response = $this->adapter->get('accounts/' . $accountId . '/images/v1/keys');

        $this->body = json_decode($response->getBody());

        return $this->body;
    }
}
