<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Exception\DomainException;
use FAPI\PhraseApp\Model\Key\KeyCreated;
use FAPI\PhraseApp\Model\Key\KeySearchResults;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Key extends HttpApi
{
    /**
     * Create a new key.
     *
     * @param string $projectKey
     * @param string $name
     * @param array  $params
     *
     * @throws DomainException
     * @throws ClientExceptionInterface
     *
     * @return KeyCreated|ResponseInterface
     */
    public function create(string $projectKey, string $name, array $params = [])
    {
        $params['name'] = $name;

        $response = $this->httpPost(sprintf('/api/v2/projects/%s/keys', $projectKey), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, KeyCreated::class);
    }

    /**
     * Search keys.
     *
     * @param string $projectKey
     * @param array  $params
     *
     * @throws ClientExceptionInterface
     * @throws DomainException
     *
     * @return KeySearchResults|ResponseInterface
     */
    public function search(string $projectKey, array $params = [])
    {
        $q = '';

        if (isset($params['tags'])) {
            $q .= 'tags:'.$params['tags'].' ';
        }

        if (isset($params['name'])) {
            $q .= 'name:'.$params['name'].' ';
        }

        if (isset($params['ids'])) {
            $q .= 'ids:'.$params['ids'].' ';
        }

        if (!empty($q)) {
            $params['q'] = $q;
        }

        $response = $this->httpPost(sprintf('/api/v2/projects/%s/keys/search', $projectKey), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, KeySearchResults::class);
    }

    /**
     * Delete a key.
     *
     * @param string $projectKey
     * @param string $keyId
     *
     * @throws ClientExceptionInterface
     * @throws DomainException
     *
     * @return bool|ResponseInterface
     */
    public function delete(string $projectKey, string $keyId)
    {
        $response = $this->httpDelete(sprintf('/api/v2/projects/%s/keys/%s', $projectKey, $keyId));

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 204) {
            $this->handleErrors($response);
        }

        return true;
    }
}
