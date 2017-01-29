<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Model\Key\KeyCreated;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Key extends HttpApi
{
    /**
     * Create a new key
     *
     * @param string    $projectKey
     * @param string    $localeId
     * @param array     $params
     * @return mixed|ResponseInterface
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
}
