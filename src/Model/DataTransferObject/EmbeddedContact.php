<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

abstract class EmbeddedContact
{
    use ContactData;

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $result = new static();

        $result->salutation = $data['salutation'];
        $result->firstname = $data['firstname'];
        $result->lastname = $data['lastname'];
        $result->telephone = $data['telephone'];
        $result->email = $data['email'];
        $result->addressLine1 = $data['addressLine1'];
        $result->addressLine2 = $data['addressLine2'];
        $result->addressLine3 = $data['addressLine3'];
        $result->addressZip = $data['addressZip'];
        $result->addressCity = $data['addressCity'];
        $result->addressState = $data['addressState'];
        $result->addressCountry = $data['addressCountry'] ? Country::fromResource($data['addressCountry']) : null;
        $result->organisationType = $data['organisationType'] ? OrganisationType::fromResource($data['organisationType']) : null;
        $result->organisationName = $data['organisationName'];
        $result->organisationUnit = $data['organisationUnit'];
        $result->organisationDuns = $data['organisationDuns'];
        $result->jurisdictionAgency = $data['jurisdictionAgency'];
        $result->jurisdictionNumber = $data['jurisdictionNumber'];
        $result->jurisdictionCity = $data['jurisdictionCity'];
        $result->jurisdictionState = $data['jurisdictionState'];
        $result->jurisdictionCountry = $data['jurisdictionCountry'] ? Country::fromResource($data['jurisdictionCountry']) : null;

        return $result;
    }
}
