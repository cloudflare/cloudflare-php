<?php

/**
 * User: junade
 * Date: 01/02/2017
 * Time: 12:50
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    public function testGetUserDetails()
    {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "7c5dae5552338874e5053f2534d2767a",
    "email": "user@example.com",
    "first_name": "John",
    "last_name": "Appleseed",
    "username": "cfuser12345",
    "telephone": "+1 123-123-1234",
    "country": "US",
    "zipcode": "12345",
    "created_on": "2014-01-01T05:20:00Z",
    "modified_on": "2014-01-01T05:20:00Z",
    "two_factor_authentication_enabled": false
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $user = new \Cloudflare\API\Endpoints\User($mock);
        $details = $user->getUserDetails();

        $this->assertObjectHasAttribute("id", $details);
        $this->assertEquals("7c5dae5552338874e5053f2534d2767a", $details->id);
        $this->assertObjectHasAttribute("email", $details);
        $this->assertEquals("user@example.com", $details->email);
    }

    public function testGetUserID()
    {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "7c5dae5552338874e5053f2534d2767a",
    "email": "user@example.com",
    "first_name": "John",
    "last_name": "Appleseed",
    "username": "cfuser12345",
    "telephone": "+1 123-123-1234",
    "country": "US",
    "zipcode": "12345",
    "created_on": "2014-01-01T05:20:00Z",
    "modified_on": "2014-01-01T05:20:00Z",
    "two_factor_authentication_enabled": false
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $user = new \Cloudflare\API\Endpoints\User($mock);
        $this->assertEquals("7c5dae5552338874e5053f2534d2767a", $user->getUserID());
    }

    public function testGetUserEmail()
    {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "7c5dae5552338874e5053f2534d2767a",
    "email": "user@example.com",
    "first_name": "John",
    "last_name": "Appleseed",
    "username": "cfuser12345",
    "telephone": "+1 123-123-1234",
    "country": "US",
    "zipcode": "12345",
    "created_on": "2014-01-01T05:20:00Z",
    "modified_on": "2014-01-01T05:20:00Z",
    "two_factor_authentication_enabled": false
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $user = new \Cloudflare\API\Endpoints\User($mock);
        $this->assertEquals("user@example.com", $user->getUserEmail());
    }

    public function testUpdateUserDetails()
    {
        $stream = GuzzleHttp\Psr7\stream_for('
{
  "success": true,
  "errors": [],
  "messages": [],
  "result": {
    "id": "7c5dae5552338874e5053f2534d2767a",
    "email": "user@example.com",
    "first_name": "John",
    "last_name": "Appleseed",
    "username": "cfuser12345",
    "telephone": "+1 123-123-1234",
    "country": "US",
    "zipcode": "12345",
    "created_on": "2014-01-01T05:20:00Z",
    "modified_on": "2014-01-01T05:20:00Z",
    "two_factor_authentication_enabled": false
  }
}');
        $response = new GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);
        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with($this->equalTo('user'), $this->equalTo([]), $this->equalTo(['email' => 'user2@example.com']));

        $user = new \Cloudflare\API\Endpoints\User($mock);
        $user->updateUserDetails(['email' => "user2@example.com"]);
    }
}
