<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\PhraseApp;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Configure an HTTP client.
 *
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * @internal This class should not be used outside of the API Client, it is not part of the BC promise.
 */
final class HttpClientConfigurator
{
    /**
     * @var string
     */
    private $endpoint = 'https://api.phraseapp.com';

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Plugin[]
     */
    private $prependPlugins = [];

    /**
     * @var Plugin[]
     */
    private $appendPlugins = [];

    /**
     * @var string
     */
    private $token;

    /**
     * @param string          $token
     * @param HttpClient|null $httpClient
     * @param UriFactoryInterface|null $uriFactory
     */
    public function __construct(string $token, HttpClient $httpClient = null, UriFactoryInterface $uriFactory = null)
    {
        $this->token = $token;
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUrlFactory();
    }

    /**
     * @return HttpClient
     */
    public function createConfiguredClient(): HttpClient
    {
        $plugins = $this->prependPlugins;

        $plugins[] = new Plugin\AuthenticationPlugin(new BasicAuth($this->token, ''));
        $plugins[] = new Plugin\AddHostPlugin($this->uriFactory->createUri($this->endpoint));
        $plugins[] = new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => 'FriendsOfApi/PhraseApp (https://github.com/FriendsOfApi/phraseapp)',
        ]);

        return new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));
    }

    /**
     * @param string $endpoint
     *
     * @return HttpClientConfigurator
     */
    public function setEndpoint(string $endpoint): HttpClientConfigurator
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param Plugin ...$plugin
     *
     * @return HttpClientConfigurator
     */
    public function appendPlugin(Plugin ...$plugin): HttpClientConfigurator
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param Plugin ...$plugin
     *
     * @return HttpClientConfigurator
     */
    public function prependPlugin(Plugin ...$plugin): HttpClientConfigurator
    {
        $plugin = array_reverse($plugin);
        foreach ($plugin as $p) {
            array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}
