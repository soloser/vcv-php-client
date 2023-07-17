<?php

declare(strict_types=1);

namespace VcvApi\Tests\Http;

use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use VcvApi\Exception\ApiLimitExceededException;
use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Exception\ValidationFailedException;
use VcvApi\Http\Client;

class ClientTest extends TestCase
{

    /**
     * @var MockObject|GuzzleClient
     */
    private MockObject $guzzleClient;

    /**
     * @var Client
     */
    private Client $client;

    public function setUp(): void
    {
        $this->guzzleClient = $this->createMock(GuzzleClient::class);
        $this->client = new Client($this->guzzleClient);
    }

    public function testGet(): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $responseBody = ['some' => 'object'];
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn(json_encode($responseBody));
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($uri), $this->equalTo([RequestOptions::QUERY => $queryParams]))
            ->willReturn($response);
        $this->assertEquals($responseBody, $this->client->get($uri, $queryParams));
    }

    public function testDelete(): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $responseBody = ['response' => 'object'];
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn(json_encode($responseBody));
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('DELETE'), $this->equalTo($uri), $this->equalTo([RequestOptions::QUERY => $queryParams]))
            ->willReturn($response);
        $this->assertEquals($responseBody, $this->client->delete($uri, $queryParams));
    }

    public function testPatch(): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $responseBody = ['response' => 'object'];
        $requestBody = ['request' => 'object'];
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn(json_encode($responseBody));
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $options = [
            RequestOptions::QUERY => $queryParams,
            RequestOptions::BODY => json_encode($requestBody),
            RequestOptions::HEADERS => ['Content-Type' => 'application/json']
        ];
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('PATCH'), $this->equalTo($uri), $this->equalTo($options))
            ->willReturn($response);
        $this->assertEquals($responseBody, $this->client->patch($uri, $requestBody, $queryParams));
    }

    public function testPost(): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $responseBody = ['some-response' => 'object'];
        $requestBody = ['some-request' => 'object'];
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn(json_encode($responseBody));
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $options = [
            RequestOptions::QUERY => $queryParams,
            RequestOptions::BODY => json_encode($requestBody),
            RequestOptions::HEADERS => ['Content-Type' => 'application/json']
        ];
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('POST'), $this->equalTo($uri), $this->equalTo($options))
            ->willReturn($response);
        $this->assertEquals($responseBody, $this->client->post($uri, $requestBody, $queryParams));
    }

    public function testApiLimitException(): void
    {
        $this->statusExceptionTest(StatusCodeInterface::STATUS_TOO_MANY_REQUESTS, ApiLimitExceededException::class);
    }

    public function testValidationException(): void
    {
        $this->statusExceptionTest(StatusCodeInterface::STATUS_BAD_REQUEST, ValidationFailedException::class);
    }

    public function testResourceNotFoundException(): void
    {
        $this->statusExceptionTest(StatusCodeInterface::STATUS_NOT_FOUND, ResourceNotFoundException::class);
    }

    public function testRuntimeException(): void
    {
        $this->statusExceptionTest(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR, RuntimeException::class);
    }

    private function statusExceptionTest(int $status, string $expectedException): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $options = [
            RequestOptions::QUERY => $queryParams,
        ];
        $exceptionMessage = 'exception message';
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn($exceptionMessage);
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getStatusCode')->willReturn($status);
        $request = $this->createStub(RequestInterface::class);
        $exception = new BadResponseException($exceptionMessage, $request, $response);
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($uri), $this->equalTo($options))
            ->willThrowException($exception);
        $this->expectException($expectedException);
        $this->client->get($uri, $queryParams);
    }

    public function testGuzzleException(): void
    {
        $uri = 'some-uri';
        $queryParams = ['some' => 'params'];
        $options = [
            RequestOptions::QUERY => $queryParams,
        ];
        $exception = $this->createStub(GuzzleException::class);
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo($uri), $this->equalTo($options))
            ->willThrowException($exception);
        $this->expectException(RuntimeException::class);
        $this->client->get($uri, $queryParams);
    }

    public function testInvalidJsonResponse(): void
    {
        $uri = 'some-uri';
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn('{incorrect json"}');
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $this->guzzleClient->expects($this->once())
            ->method('request')
            ->willReturn($response);
        $this->expectException(RuntimeException::class);
        $this->client->get($uri);
    }
}