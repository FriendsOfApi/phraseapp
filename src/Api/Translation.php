<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Model\Translation\Index;
use FAPI\PhraseApp\Model\Translation\TranslationCreated;
use FAPI\PhraseApp\Model\Translation\TranslationUpdated;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Translation extends HttpApi
{
    /**
     * Index a locale.
     *
     * @param string $projectKey
     * @param string $localeId
     * @param array  $params
     *
     * @return Index|ResponseInterface
     */
    public function indexLocale(string $projectKey, string $localeId, array $params = [])
    {
        if (isset($params['tags'])) {
            $params['q'] = 'tags:'.$params['tags'];
            unset($params['tags']);
        }

        $response = $this->httpGet(sprintf('/api/v2/projects/%s/locales/%s/translations', $projectKey, $localeId), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Index::class);
    }

    /**
     * Create a translation.
     *
     * @param string $projectKey
     * @param string $keyId
     * @param string $content
     * @param array  $params
     *
     * @return TranslationCreated|ResponseInterface
     */
    public function create(string $projectKey, string $localeId, string $keyId, string $content, array $params = [])
    {
        $params['locale_id'] = $localeId;
        $params['key_id'] = $keyId;
        $params['content'] = $content;

        $response = $this->httpPost(sprintf('/api/v2/projects/%s/translations', $projectKey), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TranslationCreated::class);
    }

    /**
     * Update a translation.
     *
     * @param string $projectKey
     * @param string $translationId
     * @param string $content
     * @param array  $params
     *
     * @return TranslationUpdated|ResponseInterface
     */
    public function update(string $projectKey, string $translationId, string $content, array $params = [])
    {
        $params['content'] = $content;

        $response = $this->httpPatch(sprintf('/api/v2/projects/%s/translations/%s', $projectKey, $translationId), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TranslationUpdated::class);
    }

    /**
     * List translations for a specific key.
     *
     * @param string $projectKey
     * @param string $keyId
     * @param array  $params
     *
     * @return Index|ResponseInterface
     */
    public function indexKey(string $projectKey, string $keyId, array $params = [])
    {
        if (isset($params['tags'])) {
            $params['q'] = 'tags:'.$params['tags'];
            unset($params['tags']);
        }

        $response = $this->httpGet(sprintf('/api/v2/projects/%s/keys/%s/translations', $projectKey, $keyId), $params);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Index::class);
    }
}
