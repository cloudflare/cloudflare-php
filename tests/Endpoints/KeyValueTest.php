<?php

namespace Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\AccountRoles;
use Cloudflare\API\Endpoints\KeyValue;
use GuzzleHttp\Psr7\Response;
use TestCase;

class KeyValueTest extends TestCase
{
    public const TEST_ACCOUNT_ID = 'eea5a600713bf7bdbba01b5108f6cf36';
    public const TEST_KV_NAMESPACE_ID = '96069a97c55cecb83b9a7a6225b1c44a';
    public const TEST_KEY_NAME = 'My-Test-Key';
    public const TEST_KEY_VALUE = 'My-Test-Key-Value';
    public const TEST_KEY_METADATA = ['test' => 'metadata'];

    public function testListKeys()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listKeys.json');

        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('get')->willReturn($response);

        $adapter->expects($this->once())
            ->method('get')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->listKeys(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals(self::TEST_KEY_NAME, $result->result[0]->name);
        $this->assertEquals(1, $result->result_info->count);
    }

    public function testGetKeyValue()
    {
        $stream = $this->getPsr7StreamForFixture('Endpoints/getKeyValue.txt');
        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('get')->willReturn(new Response(200, ['Content-Type' => 'application/json'], $stream));

        $adapter->expects($this->once())
            ->method('get')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/values', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->getKeyValue(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME);

        $this->assertEquals(self::TEST_KEY_VALUE, $result);
    }

    public function testGetKeyMetadata()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getKeyMetadata.json');
        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('get')->willReturn($response);

        $adapter->expects($this->once())
            ->method('get')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/metadata/%s', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->getKeyMetadata(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME);

        $this->assertEquals((object) self::TEST_KEY_METADATA, $result);
    }

    public function testSetKeyValue()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/setKeyValue.json');

        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('put')->willReturn($response);

        $adapter->expects($this->once())
            ->method('put')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->setKeyValue(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME, self::TEST_KEY_VALUE);

        $this->assertEquals(true, $result);
    }

    public function testSetMultipleKeysValues()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/setMultipleKeysValues.json');

        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('put')->willReturn($response);

        $adapter->expects($this->once())
            ->method('put')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/bulk', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->setMultipleKeysValues(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, [self::TEST_KEY_NAME => self::TEST_KEY_VALUE]);

        $this->assertEquals(true, $result);
    }

    public function testDeleteKey()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteKey.json');
        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('delete')->willReturn($response);

        $adapter->expects($this->once())
            ->method('delete')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/values/%s', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->deleteKey(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, self::TEST_KEY_NAME);

        $this->assertEquals(true, $result);
    }

    public function testDeleteMultipleKeys()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteKey.json');
        $adapter = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $adapter->method('delete')->willReturn($response);

        $adapter->expects($this->once())
            ->method('delete')
            ->with($this->stringStartsWith(sprintf('accounts/%s/storage/kv/namespaces/%s/bulk', self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID)));

        $keyValue  = new KeyValue($adapter);
        $result = $keyValue->deleteMultipleKeys(self::TEST_ACCOUNT_ID, self::TEST_KV_NAMESPACE_ID, [self::TEST_KEY_NAME]);

        $this->assertEquals(true, $result);
    }
}
