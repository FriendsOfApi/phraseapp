<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Model\Translation;

use FAPI\PhraseApp\Model\CreatableFromArray;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class LocaleIndex implements CreatableFromArray
{
    /**
     * @var Translation[]
     */
    private $translations = [];

    public static function createFromArray(array $data)
    {
        $self = new self();

        foreach ($data as $translation) {
            $self->addTranslation(Translation::createFromArray($translation));
        }

        return $self;
    }

    /**
     * @return Translation[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    private function addTranslation(Translation $translation)
    {
        $this->translations[] = $translation;
    }
}
