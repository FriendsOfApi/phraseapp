<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Model\Translation;

use FAPI\PhraseApp\Model\CreatableFromArray;
use Traversable;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Index implements CreatableFromArray, \IteratorAggregate
{
    /**
     * @var Translation[]
     */
    private $translations = [];

    /**
     * @param array $data
     *
     * @return Index
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        foreach ($data as $translation) {
            $self->addTranslation(Translation::createFromArray($translation));
        }

        return $self;
    }

    /**
     * @return Translation[]|\Iterator
     */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->translations);
    }

    private function addTranslation(Translation $translation)
    {
        $this->translations[] = $translation;
    }
}
