<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Model\Key;

use FAPI\PhraseApp\Model\CreatableFromArray;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class KeySearchResults implements CreatableFromArray, \IteratorAggregate
{
    /**
     * @var KeySearchResult[]
     */
    private $searchResults = [];

    /**
     * @param array $data
     *
     * @return KeySearchResults
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        foreach ($data as $searchResult) {
            $self->addSearchResult(KeySearchResult::createFromArray($searchResult));
        }

        return $self;
    }

    /**
     * @return KeySearchResult[]|\Iterator
     */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->searchResults);
    }

    private function addSearchResult(KeySearchResult $searchResult)
    {
        $this->searchResults[] = $searchResult;
    }
}
