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
class KeyCreated implements CreatableFromArray
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
    private $description;

    /**
     * @var string
     */
    private $nameHash;

    /**
     * @var bool
     */
    private $plural;

    /**
     * @var string
     */
    private $namePlural;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

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
     * @return KeyCreated
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
        if (isset($data['description'])) {
            $self->setDescription($data['description']);
        }
        if (isset($data['name_hash'])) {
            $self->setNameHash($data['name_hash']);
        }
        if (isset($data['plural'])) {
            $self->setPlural($data['plural']);
        }
        if (isset($data['name_plural'])) {
            $self->setNamePlural($data['name_plural']);
        }
        if (isset($data['created_at'])) {
            $self->setCreatedAt($data['created_at']);
        }
        if (isset($data['updated_at'])) {
            $self->setUpdatedAt($data['updated_at']);
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

    public function getNamePlural(): string
    {
        return $this->namePlural;
    }

    private function setNamePlural(string $namePlural)
    {
        $this->namePlural = $namePlural;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    private function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getNameHash(): string
    {
        return $this->nameHash;
    }

    private function setNameHash(string $nameHash)
    {
        $this->nameHash = $nameHash;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    private function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
