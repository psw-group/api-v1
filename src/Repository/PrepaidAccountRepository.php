<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Resource\PrepaidAccount;
use Throwable;

/**
 * @extends AbstractRepository<PrepaidAccount>
 */
class PrepaidAccountRepository extends AbstractRepository
{
    /**
     * Loads a prepaid account resource.
     */
    public function load(): ?PrepaidAccount
    {
        try {
            $resource = $this->client->get($this->getBaseUrl());
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    protected function getBaseUrl(): string
    {
        return '/prepaid-account';
    }

    /**
     * @return PrepaidAccount
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return PrepaidAccount::fromResource($resource);
    }
}
