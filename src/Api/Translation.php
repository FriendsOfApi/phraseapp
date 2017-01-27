<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Model\Translation\TranslationDeleted;
use FAPI\PhraseApp\Model\Translation\Translation as TranslationModel;
use GuzzleHttp\Psr7\Response;
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
     * @param string $localeId
     *
     * @return TranslationModel|ResponseInterface
     *
     * @throws Exception
     */
    public function get(string $projectKey, string $domain, string $id, string $localeId)
    {
        $response = $this->httpGet(sprintf(
            '/api/v2/projects/%s/translations?q=tags:%s',
            $projectKey,
            $domain
        ));

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        $body = $response->getBody()->__toString();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') !== 0) {
            throw new Exception\HydrationException('The ModelHydrator cannot hydrate response with Content-Type:'.$response->getHeaderLine('Content-Type'));
        }

        $data = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception\HydrationException(sprintf('Error (%d) when trying to json_decode response', json_last_error()));
        }

        foreach ($data as $translation) {
            if ($translation['key']['name'] === $id && $translation['locale']['id'] === $localeId) {
                $response = new Response(200, ['Content-Type' => 'application/json'], \json_encode($translation));
                return $this->hydrator->hydrate($response, TranslationModel::class);
            }
        }

        throw new Exception\Domain\NotFoundException();
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
