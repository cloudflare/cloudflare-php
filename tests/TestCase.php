<?php
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * Returns a PSR7 Stream for a given fixture.
     *
     * @param  string     $fixture The fixture to create the stream for.
     * @return Stream
     */
    protected function getPsr7StreamForFixture($fixture): Stream
    {
        $path = sprintf('%s/Fixtures/%s', __DIR__, $fixture);

        $this->assertFileExists($path);

        $stream = Utils::streamFor(file_get_contents($path));

        $this->assertInstanceOf(Stream::class, $stream);

        return $stream;
    }

    /**
     * Returns a PSR7 Response (JSON) for a given fixture.
     *
     * @param  string        $fixture    The fixture to create the response for.
     * @param  integer       $statusCode A HTTP Status Code for the response.
     * @return Response
     */
    protected function getPsr7JsonResponseForFixture($fixture, $statusCode = 200): Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);

        $this->assertNotNull(json_decode($stream, false));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Response($statusCode, ['Content-Type' => 'application/json'], $stream);
    }
}
