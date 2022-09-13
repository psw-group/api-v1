<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class Constraint
{
    /**
     * @var string Type of the constraint
     */
    private $type;

    /**
     * @var array<string, mixed> Parameters of the constraint
     */
    private $parameters;

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
     * @param array<string, mixed> $resource
     */
    public static function fromArray(array $resource): self
    {
        $result = new self();

        $result->type = $resource['type'];
        $result->parameters = $resource['parameters'];

        return $result;
    }
}
