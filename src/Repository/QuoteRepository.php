<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Request\QuoteRequest;
use PswGroup\Api\Model\Resource\Quote;

class QuoteRepository extends AbstractRepository
{
    /**
     * Retrieves a new quote for the given request.
     */
    public function quote(QuoteRequest $request): Quote
    {
        $resource = $this->client->post($this->getBaseUrl(), $request);

        return $this->entityFromResource($resource);
    }

    protected function getBaseUrl(): string
    {
        return '/quotes';
    }

    /**
     * @return Quote
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Quote::fromResource($resource);
    }
}
