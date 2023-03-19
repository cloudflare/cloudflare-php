<?php

use Cloudflare\API\Adapter\ResponseException;

class GuzzleTest extends TestCase
{
    private $client;

    public function setUp()
    {
        $auth = $this->getMockBuilder(\Cloudflare\API\Auth\Auth::class)
            ->setMethods(['getHeaders'])
            ->getMock();

        $auth->method('getHeaders')
            ->willReturn(['X-Testing' => 'Test']);

        $this->client = new \Cloudflare\API\Adapter\Guzzle($auth, 'https://httpbin.org/');
    }

    public function testGet()
    {
        $response = $this->client->get('https://httpbin.org/get');

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Test', $body->headers->{'X-Testing'});

        $response = $this->client->get('https://httpbin.org/get', [], ['X-Another-Test' => 'Test2']);
        $body = json_decode($response->getBody());
        $this->assertEquals('Test2', $body->headers->{'X-Another-Test'});
    }

    public function testPost()
    {
        $response = $this->client->post('https://httpbin.org/post', ['X-Post-Test' => 'Testing a POST request.']);

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Testing a POST request.', $body->json->{'X-Post-Test'});
    }

    public function testPut()
    {
        $response = $this->client->put('https://httpbin.org/put', ['X-Put-Test' => 'Testing a PUT request.']);

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Testing a PUT request.', $body->json->{'X-Put-Test'});
    }

    public function testPatch()
    {
        $response = $this->client->patch(
            'https://httpbin.org/patch',
            ['X-Patch-Test' => 'Testing a PATCH request.']
        );

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Testing a PATCH request.', $body->json->{'X-Patch-Test'});
    }

    public function testDelete()
    {
        $response = $this->client->delete(
            'https://httpbin.org/delete',
            ['X-Delete-Test' => 'Testing a DELETE request.']
        );

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Testing a DELETE request.', $body->json->{'X-Delete-Test'});
    }

    public function testNotFound()
    {
        $this->expectException(ResponseException::class);
        $this->client->get('https://httpbin.org/status/404');
    }

    public function testServerError()
    {
        $this->expectException(ResponseException::class);
        $this->client->get('https://httpbin.org/status/500');
    }
}
