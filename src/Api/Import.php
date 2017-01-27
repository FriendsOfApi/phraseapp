<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Exception;
use FAPI\PhraseApp\Model\Import\Imported;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Import extends HttpApi
{
    /**
     * Import a locale.
     *
     * @param string $projectKey
     * @param string $ext
     * @param string $filename
     * @param array  $params
     *
     * @return string|ResponseInterface
     *
     * @throws Exception
     */
    public function import(string $projectKey, string $ext, string $filename, array $params)
    {
        if (!file_exists($filename)) {
            throw new Exception\InvalidArgumentException('file ' . $filename . ' not found');
        }

        if (!isset($params['locale_id'])) {
            throw new Exception\InvalidArgumentException('locale_id is missing in params');
        }

        $postData = [
            ['name' => 'file', 'content' => $filename, 'filename' => basename($filename)],
            ['name' => 'file_format', 'content' => $ext],
            ['name' => 'locale_id', 'content' => $params['locale_id']],
        ];

        if (isset($params['tags'])) {
            $postData[] = ['name' => 'tags', 'content' => $params['tags']];
        }

        $response = $this->httpPostRaw(sprintf('/api/v2/projects/%s/uploads', $projectKey), $postData, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Imported::class);
    }
}
