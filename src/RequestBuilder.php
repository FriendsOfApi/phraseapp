<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\PhraseApp;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * @internal This class should not be used outside of the API Client, it is not part of the BC promise.
 */
final class RequestBuilder
{
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;
    /**
     * @var MultipartStreamBuilder
     */
    private $multipartStreamBuilder;

    /**
     * @param RequestFactoryInterface|null  $requestFactory
     * @param MultipartStreamBuilder|null   $multipartStreamBuilder
     */
    public function __construct(
        RequestFactoryInterface $requestFactory = null,
        MultipartStreamBuilder $multipartStreamBuilder = null
    ) {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->multipartStreamBuilder = $multipartStreamBuilder ?: new MultipartStreamBuilder();
    }

    /**
     * Creates a new PSR-7 request.
     *
     * @param string            $method
     * @param string            $uri
     * @param array             $headers
     * @param array|string|null $body    Request body. If body is an array we will send a as multipart stream request.
     *                                   If array, each array *item* MUST look like:
     *                                   array (
     *                                   'content' => string|resource|StreamInterface,
     *                                   'name'    => string,
     *                                   'filename'=> string (optional)
     *                                   'headers' => array (optinal) ['header-name' => 'header-value']
     *                                   )
     *
     * @return RequestInterface
     */
    public function create(string $method, string $uri, array $headers = [], $body = null): RequestInterface
    {
        if (!is_array($body)) {
            return $this->requestFactory->createRequest($method, $uri, $headers, $body);
        }
        foreach ($body as $item) {
            $name = $item['name'];
            $content = $item['content'];
            unset($item['name'], $item['content']);
            $this->multipartStreamBuilder->addResource($name, $content, $item);
        }
        $multipartStream = $this->multipartStreamBuilder->build();
        $boundary = $this->multipartStreamBuilder->getBoundary();
        $headers['Content-Type'] = 'multipart/form-data; boundary='.$boundary;
        $this->multipartStreamBuilder->reset();

        return $this->requestFactory->createRequest($method, $uri, $headers, $multipartStream);
    }
}
