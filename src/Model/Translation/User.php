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
class User implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $name;

    /**
     * @param array $data
     * 
     * @return User
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        if (isset($data['id'])) {
            $self->setId($data['id']);
        }
        if (isset($data['username'])) {
            $self->setUsername($data['username']);
        }
        if (isset($data['name'])) {
            $self->setName($data['name']);
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

    public function getUsername(): string
    {
        return $this->username;
    }

    private function setUsername(string $username)
    {
        $this->username= $username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setName(string $name)
    {
        $this->name = $name;
    }
}
