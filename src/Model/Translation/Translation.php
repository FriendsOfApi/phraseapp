<?php

declare(strict_types=1);

namespace FAPI\PhraseApp\Model\Translation;

use FAPI\PhraseApp\Model\CreatableFromArray;

class Translation implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $translation = '';

    /**
     * @var string
     */
    private $modified = '';

    /**
     * @var array
     */
    private $locale = [];

    private function __construct()
    {
    }

    /**
     * @param array $data
     *
     * @return Translation
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        if (isset($data['id'])) {
            $self->setId($data['id']);
        }
        if (isset($data['content'])) {
            $self->setTranslation($data['content']);
        }
        if (isset($data['updated_at'])) {
            $self->setModified($data['updated_at']);
        }
        if (isset($data['locale']['id'])) {
            $self->setLocaleId($data['locale']['id']);
        }
        if (isset($data['locale']['name'])) {
            $self->setLocale($data['locale']['name']);
        }

        return $self;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->translation;
    }

    /**
     * @param string $translation
     */
    private function setTranslation($translation)
    {
        $this->translation = $translation;
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return $this->modified;
    }

    /**
     * @param string $modified
     */
    private function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale['name'];
    }

    /**
     * @return string
     */
    public function getLocaleId()
    {
        return $this->locale['id'];
    }

    /**
     * @param string $locale
     */
    private function setLocale($locale)
    {
        $this->locale['name'] = $locale;
    }

    private function setLocaleId($localeId)
    {
        $this->locale['id'] = $localeId;
    }
}
