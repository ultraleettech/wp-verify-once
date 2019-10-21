<?php

namespace Tests\Feature;

use TypeError;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Ultraleet\VerifyOnce\API;
use GuzzleHttp\Psr7\Response;
use Ultraleet\VerifyOnce\VerifyOnce;
use GuzzleHttp\Exception\ClientException;
use Ultraleet\VerifyOnce\Exceptions\AuthenticationException;

class InitiateTest extends TestCase
{
    /** @var VerifyOnce */
    private $verifyOnce;

    /** @var Client|\PHPUnit\Framework\MockObject\MockObject  */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $config = [
            'username' => 'test',
            'password' => 'test',
        ];
        $this->client = $this->createMock(Client::class);

        $api = new API($config);
        $api->setClient($this->client);

        $this->verifyOnce = new VerifyOnce($config);
        $this->verifyOnce->setApi($api);
    }

    private function createResponse(int $status, $body): Response
    {
        $responseBody = json_encode($body);
        return new Response($status, [], $responseBody);
    }

    private function mockResponse(Response $response)
    {
        return $this->client->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('post'), $this->equalTo(['initiate']))
            ->willReturn($response);
    }

    private function mockException($exception)
    {
        return $this->client->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('post'), $this->equalTo(['initiate']))
            ->willThrowException($exception);
    }

    public function testWithValidResponse()
    {
        $responseArray = [
            'transactionId' => 'test',
            'url' => 'testUrl',
        ];
        $response = $this->createResponse(200, $responseArray);
        $this->mockResponse($response);

        $result = $this->verifyOnce->initiate();
        $this->assertSame($responseArray, $result->toArray());
    }

    public function testWithInvalidResponse()
    {
        $responseArray = [
            'transactionId' => null,
            'url' => null,
        ];
        $response = $this->createResponse(200, $responseArray);
        $this->mockResponse($response);

        $this->expectException(TypeError::class);
        $result = $this->verifyOnce->initiate();
    }

    public function testAuthenticationError()
    {
        $response = $this->createResponse(401, 'Error');
        $request = new Request('post', 'initiate');
        $exception = new ClientException('Error', $request, $response);
        $this->mockException($exception);

        $this->expectException(AuthenticationException::class);
        $result = $this->verifyOnce->initiate();
    }
}

