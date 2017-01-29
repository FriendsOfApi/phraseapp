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
class Key implements CreatableFromArray
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
     * @var bool
     */
    private $plural;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @param array $data
     *
     * @return Key
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
        if (isset($data['plural'])) {
            $self->setPlural($data['plural']);
        }
        if (isset($data['data_type'])) {
            $self->setDataType($data['data_type']);
        }
        if (isset($data['tags'])) {
            $self->setTags($data['tags']);
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

    public function isPlural(): bool
    {
        return $this->plural;
    }

    private function setPlural(bool $plural)
    {
        $this->plural = $plural;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    private function setDataType(string $dataType)
    {
        $this->dataType = $dataType;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    private function setTags(array $tags)
    {
        $this->tags = $tags;
    }
}
