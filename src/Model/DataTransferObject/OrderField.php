<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;

class OrderField
{
    /**
     * @var string Path of the field
     */
    private $path;

    /**
     * @var array<int, Constraint> Constraints which apply to the field
     */
    private $constraints;

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<int, Constraint>
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public static function fromResource(HalResource $resource): self
    {
        $result = new self();

        $result->path = $resource->getProperty('path');
        $result->constraints = [];

        foreach ($resource->getProperty('constraints') as $constraint) {
            $result->constraints[] = Constraint::fromArray($constraint);
        }

        return $result;
    }
}
