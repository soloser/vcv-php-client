<?php

declare(strict_types=1);

namespace VcvApi\Http;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use VcvApi\Exception\ApiLimitExceededException;
use VcvApi\Exception\ResourceNotFoundException;
use VcvApi\Exception\RuntimeException;
use VcvApi\Exception\ValidationFailedException;

class Client
{

    /**
     * Vcv client constructor.
     * @param GuzzleClient $guzzle
     */
    public function __construct(private GuzzleClient $guzzle)
    {

    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function get(string $uri, array $queryParams = []): array
    {
        return $this->send(RequestMethodInterface::METHOD_GET, $uri, $queryParams);
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @param array|null $bodyParams
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function delete(string $uri, array $queryParams = [], ?array $bodyParams = null): array
    {
        return $this->send(RequestMethodInterface::METHOD_DELETE, $uri, $queryParams, $bodyParams);
    }

    /**
     * @param string $uri
     * @param array $bodyParams
     * @param array $queryParams
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function patch(string $uri, array $bodyParams = [], array $queryParams = []): array
    {
        return $this->send(RequestMethodInterface::METHOD_PATCH, $uri, $queryParams, $bodyParams);
    }

    /**
     * @param string $uri
     * @param array $bodyParams
     * @param array $queryParams
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function post(string $uri, array $bodyParams = [], array $queryParams = []): array
    {
        return $this->send(RequestMethodInterface::METHOD_POST, $uri, $queryParams, $bodyParams);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    public function request(string $method, string $uri, array $options): ResponseInterface
    {
        try {
            $response = $this->guzzle->request($method, $uri, $options);
        } catch (BadResponseException $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $responseBody = $exception->getResponse()->getBody()->getContents();
            if ($statusCode === StatusCodeInterface::STATUS_BAD_REQUEST) {
                throw new ValidationFailedException($responseBody, $statusCode);
            }

            if ($statusCode === StatusCodeInterface::STATUS_TOO_MANY_REQUESTS) {
                throw new ApiLimitExceededException($responseBody, $statusCode);
            }

            if ($statusCode === StatusCodeInterface::STATUS_NOT_FOUND) {
                throw new ResourceNotFoundException($responseBody, $statusCode);
            }

            throw new RuntimeException($responseBody, $statusCode);
        } catch (GuzzleException $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode());
        }

        return $response;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $queryParams
     * @param array|null $params
     * @return array
     * @throws ValidationFailedException
     * @throws ApiLimitExceededException
     * @throws ResourceNotFoundException
     * @throws RuntimeException
     */
    private function send(string $method, string $uri, array $queryParams = [], ?array $params = null): array
    {
        $options = [RequestOptions::QUERY => $queryParams];
        if ($params !== null) {
            $options[RequestOptions::BODY] = json_encode($params);
            $options[RequestOptions::HEADERS] = ['Content-Type' => 'application/json'];
        }
        $response = $this->request($method, $uri, $options);
        $encodedResponse = json_decode($response->getBody()->getContents(), true);
        if (!is_array($encodedResponse)) {
            throw new RuntimeException('Invalid response JSON');
        }
        return $encodedResponse;
    }
}
