<?php

use GuzzleHttp\Psr7;

/**
 * Created by VSCode.
 * User: Cristiano Soares <crisnao2>
 * Date: 06/11/2022
 * Time: 13:00
 */
class ImagesTest extends TestCase
{
    private $accountId = '65as4d564asd65as1d31a2s3d465asd4';

    public function testListImages()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listImages.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->listImages($accountId = $this->accountId);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('images', $result->result);

        $this->assertEquals('KAQA3231344', $result->result->images[0]->id);
    }

    public function testGetImageDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getImageDetails.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/KAQA3231344')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->getImageDetails($accountId = $this->accountId, $imageId = 'KAQA3231344');

        $this->assertObjectHasAttribute('result', $result);

        $this->assertEquals('KAQA3231344', $result->result->id);
    }

    public function testGetImageBlob()
    {
        $response = file_get_contents(__DIR__ . '/../Fixtures/Cloudflare_Logo.svg.png');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn(new Psr7\Response(200, ['Content-Type' => 'image/png'], $response));

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/KAQA3231344/blob')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->getImageBlob($accountId = $this->accountId, $imageId = 'KAQA3231344');

        $this->assertEquals($response, $result);
    }

    public function testUploadImage()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/uploadImage.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1'),
                $this->equalTo([
                    [
                        'name'       => 'file',
                        'contents'       => file_get_contents(__DIR__ . '/../Fixtures/Cloudflare_Logo.svg.png'),
                        'filename'       => 'Cloudflare_Logo.svg.png',
                    ],
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->uploadImage(
            $accountId = $this->accountId,
            $fileOrUrl = __DIR__ . '/../Fixtures/Cloudflare_Logo.svg.png'
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('id', $result->result);

        $this->assertEquals('a4e7a418-4a8q-a158-5qap-a4125q789421', $result->result->id);
        $this->assertEquals(false, $result->result->requireSignedURLs);
    }

    public function testImportImage()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/importImage.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1'),
                $this->equalTo([
                    [
                        'name'       => 'url',
                        'contents'       => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Cloudflare_Logo.svg/1200px-Cloudflare_Logo.svg.png',
                    ],
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->uploadImage(
            $accountId = $this->accountId,
            $fileOrUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Cloudflare_Logo.svg/1200px-Cloudflare_Logo.svg.png'
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('id', $result->result);

        $this->assertEquals('1a54q565-3f3c-a4q2-5a1q-2a56q61aaawd', $result->result->id);
    }

    public function testImportImageWithCustomId()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/importImageWithCustomId.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1'),
                $this->equalTo([
                    [
                        'name'       => 'url',
                        'contents'       => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Cloudflare_Logo.svg/1200px-Cloudflare_Logo.svg.png',
                    ],
                    [
                        'name'       => 'id',
                        'contents'       => '65a4sd23asd56asd654asd564',
                    ],
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->uploadImage(
            $accountId = $this->accountId,
            $fileOrUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Cloudflare_Logo.svg/1200px-Cloudflare_Logo.svg.png',
            $id = '65a4sd23asd56asd654asd564'
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('id', $result->result);

        $this->assertEquals('65a4sd23asd56asd654asd564', $result->result->id);
    }

    public function testUpdateImage()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateImage.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/1a54q565-3f3c-a4q2-5a1q-2a56q61aaawd'),
                $this->equalTo([
                    'requireSignedURLs'       => true,
                    'metadata'       => [],
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->updateImage(
            $accountId = $this->accountId,
            $imageId = '1a54q565-3f3c-a4q2-5a1q-2a56q61aaawd',
            $requireSignedURLs = true
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('id', $result->result);

        $this->assertEquals(true, $result->result->requireSignedURLs);
    }

    public function testDeleteImage()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteImage.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/1a54q565-3f3c-a4q2-5a1q-2a56q61aaawd')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->deleteImage(
            $accountId = $this->accountId,
            $imageId = '1a54q565-3f3c-a4q2-5a1q-2a56q61aaawd'
        );

        $this->assertEquals(true, $result);
    }

    public function testGetStats()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesGetStats.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/stats')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->getStats($accountId = $this->accountId);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('count', $result->result);

        $this->assertEquals('7', $result->result->count->current);
    }

    public function testListVariants()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesListVariants.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/variants')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->listVariants($accountId = $this->accountId);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('variants', $result->result);
        $this->assertObjectHasAttribute('myVariant', $result->result->variants);
    }

    public function testGetVariantDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesGetVariantDetails.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/variants/myVariant')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->getVariantDetails($accountId = $this->accountId, $variantId = 'myVariant');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('variant', $result->result);

        $this->assertEquals('myVariant', $result->result->variant->id);
    }

    public function testAddVariant()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesAddVariant.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/variants'),
                $this->equalTo([
                    'id' => 'myVariant',
                    'options'       => [
                        'fit' => 'scale-down',
                        'metadata' => 'none',
                        'width' => 1000,
                        'height' => 1000,
                    ],
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->addVariant(
            $accountId = $this->accountId,
            $variantId = 'myVariant',
            $fit = 'scale-down',
            $metadata = 'none',
            $width = 1000,
            $height = 1000
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('variant', $result->result);
        $this->assertObjectHasAttribute('options', $result->result->variant);

        $this->assertEquals(1000, $result->result->variant->options->width);
        $this->assertEquals(1000, $result->result->variant->options->height);
        $this->assertEquals(false, $result->result->variant->neverRequireSignedURLs);
    }

    public function testUpdateVariant()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesUpdateVariant.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/variants/myVariant'),
                $this->equalTo([
                    'options'       => [
                        'fit' => 'pad',
                        'metadata' => 'none',
                        'width' => 900,
                        'height' => 900,
                    ],
                    'neverRequireSignedURLs' => true,
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->updateVariant(
            $accountId = $this->accountId,
            $variantId = 'myVariant',
            $fit = 'pad',
            $metadata = 'none',
            $width = 900,
            $height = 900,
            $neverRequireSignedURLs = true
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('variant', $result->result);
        $this->assertObjectHasAttribute('options', $result->result->variant);

        $this->assertEquals(900, $result->result->variant->options->width);
        $this->assertEquals(900, $result->result->variant->options->height);
        $this->assertEquals(true, $result->result->variant->neverRequireSignedURLs);
    }

    public function testUpdateFlexibleVariantsStatus()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesUpdateFlexibleVariantsStatus.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/config'),
                $this->equalTo([
                    'flexible_variants' => true,
                ])
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->updateFlexibleVariantsStatus(
            $accountId = $this->accountId,
            $status = true
        );

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('flexible_variants', $result->result);

        $this->assertEquals(true, $result->result->flexible_variants);
    }

    public function testDeleteVariant()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesDeleteVariant.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/variants/myVariant')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->deleteVariant(
            $accountId = $this->accountId,
            $variantId = 'myVariant'
        );

        $this->assertEquals(true, $result);
    }

    public function testListKeys()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/imagesListKeys.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/' . $this->accountId . '/images/v1/keys')
            );

        $images = new \Cloudflare\API\Endpoints\Images($mock);
        $result = $images->listKeys($accountId = $this->accountId);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('keys', $result->result);

        $this->assertEquals('default', $result->result->keys[0]->name);
    }
}
