<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\ContactData;

class AccountContact extends AbstractResource
{
    use ContactData;

    /**
     * @var string|null Number of the contact
     */
    private $number;

    /**
     * @var bool Indicates if the contact can be used as order contact
     */
    private $allowedAsOrderContact;

    /**
     * @var bool Indicates if the contact can be used as owner contact
     */
    private $allowedAsOwnerContact;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function isAllowedAsOrderContact(): bool
    {
        return $this->allowedAsOrderContact;
    }

    public function isAllowedAsOwnerContact(): bool
    {
        return $this->allowedAsOwnerContact;
    }

    public function setAllowedAsOrderContact(bool $allowedAsOrderContact): void
    {
        $this->allowedAsOrderContact = $allowedAsOrderContact;
    }

    public function setAllowedAsOwnerContact(bool $allowedAsOwnerContact): void
    {
        $this->allowedAsOwnerContact = $allowedAsOwnerContact;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->allowedAsOrderContact = $resource->getProperty('allowedAsOrderContact');
        $result->allowedAsOwnerContact = $resource->getProperty('allowedAsOwnerContact');

        $result->salutation = $resource->getProperty('salutation');
        $result->firstname = $resource->getProperty('firstname');
        $result->lastname = $resource->getProperty('lastname');
        $result->telephone = $resource->getProperty('telephone');
        $result->email = $resource->getProperty('email');
        $result->addressLine1 = $resource->getProperty('addressLine1');
        $result->addressLine2 = $resource->getProperty('addressLine2');
        $result->addressLine3 = $resource->getProperty('addressLine3');
        $result->addressZip = $resource->getProperty('addressZip');
        $result->addressCity = $resource->getProperty('addressCity');
        $result->addressState = $resource->getProperty('addressState');
        $result->addressCountry = self::loadObject($resource, 'addressCountry', Country::class);
        $result->organisationType = self::loadObject($resource, 'organisationType', OrganisationType::class);
        $result->organisationName = $resource->getProperty('organisationName');
        $result->organisationUnit = $resource->getProperty('organisationUnit');
        $result->organisationDuns = $resource->getProperty('organisationDuns');
        $result->jurisdictionAgency = $resource->getProperty('jurisdictionAgency');
        $result->jurisdictionNumber = $resource->getProperty('jurisdictionNumber');
        $result->jurisdictionCity = $resource->getProperty('jurisdictionCity');
        $result->jurisdictionState = $resource->getProperty('jurisdictionState');
        $result->jurisdictionCountry = self::loadObject($resource, 'jurisdictionCountry', Country::class);

        return $result;
    }
}
