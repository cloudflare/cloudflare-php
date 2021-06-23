<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 18/03/2018
 * Time: 22:23
 */

use Cloudflare\API\Endpoints\CustomHostnames;

class CustomHostnamesTest extends TestCase
{
    public function testAddHostname()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createCustomHostname.json');

        $customSsl = $this->getCustomSsl();

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames'),
                $this->equalTo([
                    'hostname' => 'app.example.com',
                    'custom_origin_server' => 'origin.example.com',
                    'ssl' => [
                        'method' => 'http',
                        'type' => 'dv',
                        'settings' => [
                            'http2' => 'on',
                            'http3' => 'on',
                            'min_tls_version' => '1.2',
                        ],
                        'bundle_method' => 'optimal',
                        'custom_key' => $customSsl['key'],
                        'custom_certificate' => $customSsl['certificate'],
                        'wildcard' => true,
                    ],
                ])
            );

        $hostname = new CustomHostnames($mock);
        $sslSettings = [
            'http2' => 'on',
            'http3' => 'on',
            'min_tls_version' => '1.2'
        ];

        $hostname->addHostname(
            '023e105f4ecef8ad9ca31a8372d0c353',
            'app.example.com',
            'http',
            'dv',
            $sslSettings,
            'origin.example.com',
            true,
            'optimal',
            $customSsl
        );
        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $hostname->getBody()->result->id);
    }

    public function testListHostnames()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listHostnames.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames'),
                $this->equalTo([
                    'hostname' => 'app.example.com',
                    'id' => '0d89c70d-ad9f-4843-b99f-6cc0252067e9',
                    'page' => 1,
                    'per_page' => 20,
                    'order' => 'ssl',
                    'direction' => 'desc',
                    'ssl' => 0
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\CustomHostnames($mock);
        $result = $zones->listHostnames('023e105f4ecef8ad9ca31a8372d0c353', 'app.example.com', '0d89c70d-ad9f-4843-b99f-6cc0252067e9', 1, 20, 'ssl', 'desc', 0);

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $zones->getBody()->result[0]->id);
    }

    public function testGetHostname()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getHostname.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames/0d89c70d-ad9f-4843-b99f-6cc0252067e9')
            );

        $zones = new \Cloudflare\API\Endpoints\CustomHostnames($mock);
        $result = $zones->getHostname('023e105f4ecef8ad9ca31a8372d0c353', '0d89c70d-ad9f-4843-b99f-6cc0252067e9', '0d89c70d-ad9f-4843-b99f-6cc0252067e9');

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('hostname', $result);
        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $zones->getBody()->result->id);
    }

    public function testUpdateHostname()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateHostname.json');

        $customSsl = $this->getCustomSsl();

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames/0d89c70d-ad9f-4843-b99f-6cc0252067e9'),
                $this->equalTo([
                    'custom_origin_server' => 'origin.example.com',
                    'ssl' => [
                        'method' => 'http',
                        'type' =>  'dv',
                        'settings' => [
                            'http2' => 'on',
                            'http3' => 'on',
                            'min_tls_version' => '1.2'
                        ],
                        'bundle_method' => 'optimal',
                        'custom_key' => $customSsl['key'],
                        'custom_certificate' => $customSsl['certificate'],
                        'wildcard' => true,

                    ]
                ])
            );

        $zones = new \Cloudflare\API\Endpoints\CustomHostnames($mock);
        $sslSettings = [
            'http2' => 'on',
            'http3' => 'on',
            'min_tls_version' => '1.2'
        ];

        $result = $zones->updateHostname(
            '023e105f4ecef8ad9ca31a8372d0c353',
            '0d89c70d-ad9f-4843-b99f-6cc0252067e9',
            'http',
            'dv',
            $sslSettings,
            'origin.example.com',
            true,
            'optimal',
            [
                'key' => $customSsl['key'],
                'certificate' => $customSsl['certificate'],
            ]
        );

        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('hostname', $result);
        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $zones->getBody()->result->id);
    }

    public function testDeleteHostname()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteHostname.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames/0d89c70d-ad9f-4843-b99f-6cc0252067e9')
            );

        $zones = new \Cloudflare\API\Endpoints\CustomHostnames($mock);
        $result = $zones->deleteHostname('023e105f4ecef8ad9ca31a8372d0c353', '0d89c70d-ad9f-4843-b99f-6cc0252067e9');

        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $result->id);
        $this->assertEquals('0d89c70d-ad9f-4843-b99f-6cc0252067e9', $zones->getBody()->id);
    }

    public function testGetHostnameFallbackOrigin()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCustomHostnameFallbackOrigin.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/023e105f4ecef8ad9ca31a8372d0c353/custom_hostnames/fallback_origin')
            );

        $zones = new \Cloudflare\API\Endpoints\CustomHostnames($mock);
        $result = $zones->getFallbackOrigin('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertObjectHasAttribute('origin', $result);
        $this->assertObjectHasAttribute('status', $result);
    }

    private function getCustomSsl(): array
    {
        $customKey = <<<KEY
-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDZfoCUkzkZLCzo
OFTtlXU9OYqNFx06J/GOKCwDCyfkY5RY1x6BVrVpTqf/JaU42DZmCjIiEugBg4bu
eu9/w21prIWgRKEe8mjrw83+3QSIyQrs+78rqwDptUfL+IyhYln6SBjqPQ569Y0w
x6A896PDMYPHgnWtclGwsxDNKJ2eWsH+C4UkLUeVM4BILEJ00YUjayowL/0sflTJ
yY58c9fVV27aGBJ4znreYkBojPQ0fzVZ3HJfYD+DgYUUkuzN/WohOLTNTxvzt/i2
GNxP8tZzi0E/t4KtGTsIVmROKaCXnmozQyv0VES5TNZL1nxLvVuPca9DKXwVst2o
v5czEM8fAgMBAAECggEBANgG/aIVpWYqaaRyp3CgviWE7Oh9J+um1xgzMJwJTaNd
gXDIoyUmweQKW3Vjp/uRTl8GC4uqqcUvJivj8dU+gIOw970bzcmWT7616vsV/rX6
sp524wh1vt9jzx97DfwSW3rsd8rZwHNDSO1FqxRDiOaNXO4i183iud8/zRVqHTy1
5girngsGl7ebTt3LDHDQQ86kND2nVr8xZuFaqs8Td41AsF6DGbB709wMUqoM/obO
iUtXCZ5Rrm2a78OUi0cqWsuxdhJjtOW0PBvrPTlSq+1EuQWAWV8HN1JI58YnLcLy
SKZpsu5wxWdKMgX0NCkfLjDZCAPlBaZLPPp986GHavECgYEA8hM6tIfGBnXuxBvI
y2lJG3sHGs83pnCqYg9dDrr+m3JOPQu6l9MEPEtsrOiI0Ktu/L+kV5uyBDRvB6ff
BD6BJ2CiG86UvMpKojBeAlZBLXr1SnWzIPC+3fBzkVSo1MiRs3nTNRfeblkRxC3e
LWtl96obA1GOgpifrh6ZB2RfvrcCgYEA5gFL4+oDUDcRtc1Pw+AFwPTey+3rkVU+
FHvRGeU+m6dtxXF+BYFpDs/ONfmHzsdBSwkYxta/x8rKP5uyjl9p0QSdhysrJibO
sWsoux35QxEZiyplCV2+zMK/79EhS2CuiudAidF6NxK+/g9EwXRlGDDlnFDB2epe
kyL97K4zCtkCgYEA68Bgbsq/xzD5XFG2xqr9wN6a97gQ+W5F8QQHW74vEZJLsdYH
Xa7rNBE8gFRiUd5zU4EL+yotPz0VWH5bilWZEJFirvQMFKRp9PRnyZzZEwLpeh+Q
WSc8qwZudn3dgoTmqMSfNdjODed+jvEgrFkoz/8BGcVGpdcfw8IWxIUzXZcCgYAY
/OsRx8q0XEdASR3xWdVGMVRDM4X0NB6aexkshwtWPcpfOQVH89dGFK2Cj6mBfYRK
cqKOd6Y+Pnnajz/G1/bXDnlOxhHaAz1RaSLzsT3zW1g7FlADxHuGI2JW25GSbt6H
mLgaQPfWI+M8FsyRd+PDzQwk/2EQG7ZKpfKQVByXgQKBgQDkKciB6Wb2hLNTKzK8
Kr42U70H++QT8AqZX2F79PjgYcRFZqGXLuq/hEuiOhXfl8DFur3fC5JN8AeLC5/j
bsrBsljYfVvtLQzilugs1oEe94LTrYjR2oQt0W24bqpGQHuv1ILuUBuodERkxSFL
/cMkj3wSfC341hFaJEuG1+PcxA==
-----END PRIVATE KEY-----
KEY;

        $customCertificate = <<<CERTIFICATE
-----BEGIN CERTIFICATE-----
MIIDmTCCAoGgAwIBAgIULyaeNqp0tOut/wvuxNyKmUxOGYEwDQYJKoZIhvcNAQEL
BQAwXDELMAkGA1UEBhMCWFgxFTATBgNVBAcMDERlZmF1bHQgQ2l0eTEcMBoGA1UE
CgwTRGVmYXVsdCBDb21wYW55IEx0ZDEYMBYGA1UEAwwPYXBwLmV4YW1wbGUuY29t
MB4XDTIxMDYxNDIzMzU0MVoXDTIyMDYxNDIzMzU0MVowXDELMAkGA1UEBhMCWFgx
FTATBgNVBAcMDERlZmF1bHQgQ2l0eTEcMBoGA1UECgwTRGVmYXVsdCBDb21wYW55
IEx0ZDEYMBYGA1UEAwwPYXBwLmV4YW1wbGUuY29tMIIBIjANBgkqhkiG9w0BAQEF
AAOCAQ8AMIIBCgKCAQEA2X6AlJM5GSws6DhU7ZV1PTmKjRcdOifxjigsAwsn5GOU
WNcegVa1aU6n/yWlONg2ZgoyIhLoAYOG7nrvf8NtaayFoEShHvJo68PN/t0EiMkK
7Pu/K6sA6bVHy/iMoWJZ+kgY6j0OevWNMMegPPejwzGDx4J1rXJRsLMQzSidnlrB
/guFJC1HlTOASCxCdNGFI2sqMC/9LH5UycmOfHPX1Vdu2hgSeM563mJAaIz0NH81
WdxyX2A/g4GFFJLszf1qITi0zU8b87f4thjcT/LWc4tBP7eCrRk7CFZkTimgl55q
M0Mr9FREuUzWS9Z8S71bj3GvQyl8FbLdqL+XMxDPHwIDAQABo1MwUTAdBgNVHQ4E
FgQUbAfyBm0wpM7FqUb1yqeaF4voY/gwHwYDVR0jBBgwFoAUbAfyBm0wpM7FqUb1
yqeaF4voY/gwDwYDVR0TAQH/BAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAO2Dd
k/seFjp83caYE/NVdDy5B7l5JeVtruaUdlGbb0xtVhiIdoY43ukhHFw8zuWMW9RX
SUbrzwacfKLDBikcefk9go6cMimqYIRF8Hntph1gjjqB0papUm2WVYbsBRv2okys
ej0dGSeUEsWjKRTSMkJsbbiEv6oveeSki069zl+tln0UhbHedkIY3rJsFIyoddSu
g96r5HPHksnObm1JCym0xd09+msliDkBmq87mxok9m5aEqWX4XvdGfYERV/eD5vC
KcW4DoM1KZd8E6tlniglc1jC0pzKfho7Uoe6UtObgHZGNwRYwYy+BHvHYY46ctSI
NdZ7G/lUyrBFhsRrhw==
-----END CERTIFICATE-----
CERTIFICATE;

        return [
            'key' => $customKey,
            'certificate' => $customCertificate,
        ];
    }
}
