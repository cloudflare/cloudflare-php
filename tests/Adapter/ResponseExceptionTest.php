<?php

use Cloudflare\API\Adapter\ResponseException;
use Cloudflare\API\Adapter\JSONException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ResponseExceptionTest extends TestCase
{
    public function testFromRequestExceptionNoResponse()
    {
        $reqErr = new RequestException('foo', new Request('GET', '/test'));
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals($reqErr->getMessage(), $respErr->getMessage());
        $this->assertEquals(0, $respErr->getCode());
        $this->assertEquals($reqErr, $respErr->getPrevious());
    }

    public function testFromRequestExceptionEmptyContentType()
    {
        $resp = new Response(404);
        $reqErr = new RequestException('foo', new Request('GET', '/test'), $resp);
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals($reqErr->getMessage(), $respErr->getMessage());
        $this->assertEquals(0, $respErr->getCode());
        $this->assertEquals($reqErr, $respErr->getPrevious());
    }


    public function testFromRequestExceptionUnknownContentType()
    {
        $resp = new Response(404, ['Content-Type' => ['application/octet-stream']]);
        $reqErr = new RequestException('foo', new Request('GET', '/test'), $resp);
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals($reqErr->getMessage(), $respErr->getMessage());
        $this->assertEquals(0, $respErr->getCode());
        $this->assertEquals($reqErr, $respErr->getPrevious());
    }

    public function testFromRequestExceptionJSONDecodeError()
    {
        $resp = new Response(404, ['Content-Type' => ['application/json; charset=utf-8']], '[what]');
        $reqErr = new RequestException('foo', new Request('GET', '/test'), $resp);
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals($reqErr->getMessage(), $respErr->getMessage());
        $this->assertEquals(0, $respErr->getCode());
        $this->assertInstanceOf(JSONException::class, $respErr->getPrevious());
        $this->assertEquals($reqErr, $respErr->getPrevious()->getPrevious());
    }

    public function testFromRequestExceptionJSONWithErrors()
    {
        $body = '{
          "result": null,
          "success": false,
          "errors": [{"code":1003, "message":"This is an error"}],
          "messages": []
        }';

        $resp = new Response(404, ['Content-Type' => ['application/json; charset=utf-8']], $body);
        $reqErr = new RequestException('foo', new Request('GET', '/test'), $resp);
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals('This is an error', $respErr->getMessage());
        $this->assertEquals(1003, $respErr->getCode());
        $this->assertEquals($reqErr, $respErr->getPrevious());
    }
}
