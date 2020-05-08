<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class File implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $mimeType;

    /**
     * @var string
     */
    private $content;

    public function getName(): string
    {
        return $this->name;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'mimeType' => $this->mimeType,
            'content' => $this->content,
        ];
    }
}
