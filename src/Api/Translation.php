<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Resource\Api\Translation\TranslationDeleted;
use FAPI\PhraseApp\Resource\Api\Translation\Translation as TranslationModel;
use Psr\Http\Message\ResponseInterface;
use FAPI\PhraseApp\Exception;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Translation extends HttpApi
{
    /**
     * Get a translation.
     *
     * @param string $projectKey
     * @param string $id
     * @param string $locale
     *
     * @return TranslationModel|ResponseInterface
     *
     * @throws Exception
     */
    public function get(string $projectKey, string $domain, string $id, string $locale)
    {
        $response = $this->httpGet(sprintf(
            '/api/v2/projects/%s/locales/%s/translations?q=tags:%s',
            $projectKey,
            $locale,
            $domain
        ));

        foreach ($response as $translation) {
            if ($translation['key']['name'] === "$domain::$id") {
                return TranslationModel::createFromArray(

                );
                return new Message($key, $domain, $locale, substr($translation['content'], strlen($domain) + 2));
            }
        }

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TranslationModel::class);
    }

    /**
     * Create a new translation.
     *
     * @param string $projectKey
     * @param string $id
     * @param string $locale
     * @param string $translation
     *
     * @return TranslationModel|ResponseInterface
     *
     * @throws Exception
     */
    public function create(string $projectKey, string $id, string $locale, string $translation)
    {
        $response = $this->httpPostRaw(sprintf('/api/translations/%s/%s?key=%s', $id, $locale, $projectKey), $translation);
        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TranslationModel::class);
    }

    /**
     * Delete translation
     *
     * @param string $projectKey
     * @param string $id
     * @param string $locale
     *
     * @return TranslationDeleted|ResponseInterface
     *
     * @throws Exception
     */
    public function delete(string $projectKey, string $id, string $locale)
    {
        $response = $this->httpDelete(sprintf('/api/translations/%s/%s?key=%s', $id, $locale, $projectKey));
        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, TranslationDeleted::class);
    }
}
