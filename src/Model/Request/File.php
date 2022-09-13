<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use JsonSerializable;

/**
 * Represents a file required in the validation process.
 */
class File implements JsonSerializable
{
    /**
     * @var string Name of the file
     */
    private string $name;

    /**
     * @var string|null Mime type if the file
     */
    private ?string $mimeType = null;

    /**
     * @var string Content of the file
     */
    private string $content;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return array<string, string|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'mimeType' => $this->mimeType,
            'content' => base64_encode($this->content),
        ];
    }
}
