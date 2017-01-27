<?php

declare(strict_types=1);

namespace FAPI\PhraseApp\Model\Import;

use FAPI\PhraseApp\Model\CreatableFromArray;

/**
 * @author Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 */
class Imported implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $createdAt;

    private function __construct()
    {
    }

    /**
     * @param array $data
     *
     * @return Imported
     */
    public static function createFromArray(array $data)
    {
        $self = new self();

        if (isset($data['id'])) {
            $self->setId($data['id']);
        }
        if (isset($data['filename'])) {
            $self->setFilename($data['filename']);
        }
        if (isset($data['format'])) {
            $self->setFormat($data['format']);
        }
        if (isset($data['state'])) {
            $self->setState($data['state']);
        }
        if (isset($data['created_at'])) {
            $self->setCreatedAt($data['created_at']);
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
    private function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    private function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    private function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    private function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    private function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
