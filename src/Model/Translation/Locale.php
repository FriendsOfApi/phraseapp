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
final class Locale implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @param array $data
     *
     * @return Locale
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        if (isset($data['id'])) {
            $self->setId($data['id']);
        }
        if (isset($data['name'])) {
            $self->setName($data['name']);
        }
        if (isset($data['code'])) {
            $self->setCode($data['code']);
        }

        return $self;
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function setId(string $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    private function setCode(string $code)
    {
        $this->code = $code;
    }
}
