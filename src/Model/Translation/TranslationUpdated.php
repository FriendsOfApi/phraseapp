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
class TranslationUpdated implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var bool
     */
    private $unverified;

    /**
     * @var bool
     */
    private $excluded;

    /**
     * @var string
     */
    private $pluralSuffix;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $placeholders = [];

    /**
     * @var int
     */
    private $wordCount;

    /**
     * @var Key
     */
    private $key;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var User
     */
    private $user;

    /**
     * @param array $data
     * @return TranslationUpdated
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        if (isset($data['id'])) {
            $self->setId($data['id']);
        }
        if (isset($data['content'])) {
            $self->setContent($data['content']);
        }
        if (isset($data['unverified'])) {
            $self->setUnverified($data['unverified']);
        }
        if (isset($data['excluded'])) {
            $self->setExcluded($data['excluded']);
        }
        if (isset($data['plural_suffix'])) {
            $self->setPluralSuffix($data['plural_suffix']);
        }
        if (isset($data['created_at'])) {
            $self->setCreatedAt($data['created_at']);
        }
        if (isset($data['updated_at'])) {
            $self->setUpdatedAt($data['updated_at']);
        }
        if (isset($data['placeholders'])) {
            $self->setPlaceholders($data['placeholders']);
        }
        if (isset($data['word_count'])) {
            $self->setWordCount($data['word_count']);
        }
        if (isset($data['key']) && is_array($data['key'])) {
            $self->setKey(Key::createFromArray($data['key']));
        }
        if (isset($data['locale']) && is_array($data['locale'])) {
            $self->setLocale(Locale::createFromArray($data['locale']));
        }
        if (isset($data['user']) && is_array($data['user'])) {
            $self->setUser(User::createFromArray($data['user']));
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

    public function getContent(): string
    {
        return $this->content;
    }

    private function setContent(string $content)
    {
        $this->content = $content;
    }

    public function isUnverified(): bool
    {
        return $this->unverified;
    }

    private function setUnverified(bool $unverified)
    {
        $this->unverified = $unverified;
    }

    public function isExcluded(): bool
    {
        return $this->excluded;
    }

    private function setExcluded(bool $excluded)
    {
        $this->excluded = $excluded;
    }

    public function getPluralSuffix(): string
    {
        return $this->pluralSuffix;
    }

    private function setPluralSuffix(string $pluralSuffix)
    {
        $this->pluralSuffix = $pluralSuffix;
    }

    public function getKey(): Key
    {
        return $this->key;
    }

    private function setKey(Key $key)
    {
        $this->key = $key;
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

    public function getWordCount(): int
    {
        return $this->wordCount;
    }

    private function setWordCount(int $wordCount)
    {
        $this->wordCount = $wordCount;
    }

    public function getPlaceholders(): array
    {
        return $this->placeholders;
    }

    private function setPlaceholders(array $placeholders)
    {
        $this->placeholders = $placeholders;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    private function setLocale(Locale $locale)
    {
        $this->locale = $locale;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    private function setUser(User $user)
    {
        $this->user = $user;
    }
}
