<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Exception\Domain as DomainExceptions;
use FAPI\PhraseApp\Exception\DomainException;
use FAPI\PhraseApp\Hydrator\Hydrator;
use FAPI\PhraseApp\Hydrator\NoopHydrator;
use FAPI\PhraseApp\RequestBuilder;
use Http\Client\HttpClient;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
abstract class HttpApi
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * @var RequestBuilder
     */
    protected $requestBuilder;

    /**
     * @param HttpClient     $httpClient
     * @param RequestBuilder $requestBuilder
     * @param Hydrator       $hydrator
     */
    public function __construct(HttpClient $httpClient, Hydrator $hydrator, RequestBuilder $requestBuilder)
    {
        $this->httpClient = $httpClient;
        $this->requestBuilder = $requestBuilder;
        if (!$hydrator instanceof NoopHydrator) {
            $this->hydrator = $hydrator;
        }
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path
     * @param array  $params         GET parameters
     * @param array  $requestHeaders Request Headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpGet(string $path, array $params = [], array $requestHeaders = []): ResponseInterface
    {
        if (empty($params)) {
            $path .= '?'.http_build_query($params);
        }

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('GET', $path, $requestHeaders)
        );
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param string $path           Request path
     * @param array  $params         POST parameters to be JSON encoded
     * @param array  $requestHeaders Request headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpPost(string $path, array $params = [], array $requestHeaders = []): ResponseInterface
    {
        $requestHeaders['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this->httpPostRaw($path, http_build_query($params), $requestHeaders);
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string       $path           Request path
     * @param array|string $body           Request body
     * @param array        $requestHeaders Request headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpPostRaw(string $path, $body, array $requestHeaders = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('POST', $path, $requestHeaders, $body)
        );
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param string $path           Request path
     * @param array  $params         POST parameters to be JSON encoded
     * @param array  $requestHeaders Request headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpPut(string $path, array $params = [], array $requestHeaders = []): ResponseInterface
    {
        $requestHeaders['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('PUT', $path, $requestHeaders, http_build_query($params))
        );
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path
     * @param array  $params         POST parameters to be JSON encoded
     * @param array  $requestHeaders Request headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpDelete(string $path, array $params = [], array $requestHeaders = []): ResponseInterface
    {
        $requestHeaders['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('DELETE', $path, $requestHeaders, http_build_query($params))
        );
    }

    /**
     * Send a PATCH request with json encoded data.
     *
     * @param string       $path           Request path
     * @param array|string $body           Request body
     * @param array        $requestHeaders Request headers
     *
     * @throws ClientExceptionInterface
     *
     * @return ResponseInterface
     */
    protected function httpPatch(string $path, $body, array $requestHeaders = []): ResponseInterface
    {
        $requestHeaders['Content-Type'] = 'application/json';

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('PATCH', $path, $requestHeaders, json_encode($body))
        );
    }

    /**
     * Handle HTTP errors.
     *
     * Call is controlled by the specific API methods.
     *
     * @param ResponseInterface $response
     *
     * @throws DomainException
     */
    protected function handleErrors(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case 401:
                throw new DomainExceptions\InvalidApiKeyException('Invalid API key');
                break;
            case 403:
                throw new DomainExceptions\InsufficientPrivilegesException('Insufficient Privileges');
                break;
            case 404:
                throw new DomainExceptions\NotFoundException('Not found');
                break;
            case 422:
                throw new DomainExceptions\UnprocessableEntityException('Unprocessable entity');
            case 429:
                throw new DomainExceptions\RateLimitExceededException('Rate limit exceeded');
            default:
                throw new DomainExceptions\UnknownErrorException('Unknown error');
                break;
        }
    }
}
