<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Api;

use FAPI\PhraseApp\Exception;
use FAPI\PhraseApp\Model\Locale\Uploaded;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Upload extends HttpApi
{
    /**
     * Upload a locale.
     *
     * @param string $projectKey
     * @param string $ext
     * @param string $filename
     * @param array  $params
     *
     * @throws Exception
     *
     * @return Uploaded|ResponseInterface
     */
    public function upload(string $projectKey, string $ext, string $filename, array $params)
    {
        if (!file_exists($filename)) {
            throw new Exception\InvalidArgumentException('file '.$filename.' not found');
        }

        if (!isset($params['locale_id'])) {
            throw new Exception\InvalidArgumentException('locale_id is missing in params');
        }

        $postData = [
            ['name' => 'file', 'content' => file_get_contents($filename), 'filename' => basename($filename)],
            ['name' => 'file_format', 'content' => $ext],
            ['name' => 'locale_id', 'content' => $params['locale_id']],
        ];

        if (isset($params['update_translations'])) {
            $postData[] = ['name' => 'update_translations', 'content' => $params['update_translations']];
        }

        if (isset($params['tags'])) {
            $postData[] = ['name' => 'tags', 'content' => $params['tags']];
        }

        $response = $this->httpPostRaw(sprintf('/api/v2/projects/%s/uploads', $projectKey), $postData, [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]);

        if (!$this->hydrator) {
            return $response;
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $this->handleErrors($response);
        }

        return $this->hydrator->hydrate($response, Uploaded::class);
    }
}
