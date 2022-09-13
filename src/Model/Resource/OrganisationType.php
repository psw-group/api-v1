<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a known organisation type.
 */
class OrganisationType extends AbstractResource
{
    /**
     * @var string Code of the type
     */
    private string $code;

    /**
     * @var string German name of the type
     */
    private string $name;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $code = '', string $name = '')
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->code = $resource->getProperty('code');
        $result->name = $resource->getProperty('name');

        return $result;
    }
}
