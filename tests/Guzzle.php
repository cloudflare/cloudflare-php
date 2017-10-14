<?php

namespace Helpers;
use \GuzzleHttp\Psr7 as Psr7;
class Guzzle extends \PHPUnit_Framework_TestCase
{
	function testExample(){
        $success = "abcde";
		return $success;
	}
    function getPsr7StreamForFixture($fixture): Psr7\Stream
    {
        $path = sprintf('%s/Fixtures/%s', __DIR__, $fixture);

        $this->assertFileExists($path);

        $stream = Psr7\stream_for(file_get_contents($path));

        $this->assertInstanceOf(Psr7\Stream::class, $stream);

        return $stream;
    }

    function getPsr7JsonResponseForFixture($fixture, $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);

        $this->assertNotNull(json_decode($stream));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Psr7\Response($statusCode, ['Content-Type' => 'application/json'], $stream);
    }
}
