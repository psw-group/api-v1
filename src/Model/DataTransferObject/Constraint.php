<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class Constraint
{
    /**
     * @var string Type of the constraint
     */
    private string $type;

    /**
     * @var array<string, mixed> Parameters of the constraint
     */
    private array $parameters = [];

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array{type?: string|null, parameters?: array<string, mixed>|null} $data
     */
    public static function fromArray(array $data): self
    {
        $result = new self();

        $result->type = $data['type'] ?? '';
        $result->parameters = $data['parameters'] ?? [];

        return $result;
    }
}
