<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

abstract class EmbeddedContact
{
    use ContactData;

    public static function fromArray(array $resource)
    {
        $result = new static();

        $result->salutation = $resource['salutation'];
        $result->firstname = $resource['firstname'];
        $result->lastname = $resource['lastname'];
        $result->telephone = $resource['telephone'];
        $result->email = $resource['email'];
        $result->addressLine1 = $resource['addressLine1'];
        $result->addressLine2 = $resource['addressLine2'];
        $result->addressLine3 = $resource['addressLine3'];
        $result->addressZip = $resource['addressZip'];
        $result->addressCity = $resource['addressCity'];
        $result->addressState = $resource['addressState'];
        $result->addressCountry = $resource['addressCountry'] ? Country::fromResource($resource['addressCountry']) : null;
        $result->organisationType = $resource['organisationType'] ? OrganisationType::fromResource($resource['organisationType']) : null;
        $result->organisationName = $resource['organisationName'];
        $result->organisationUnit = $resource['organisationUnit'];
        $result->organisationDuns = $resource['organisationDuns'];
        $result->jurisdictionAgency = $resource['jurisdictionAgency'];
        $result->jurisdictionNumber = $resource['jurisdictionNumber'];
        $result->jurisdictionCity = $resource['jurisdictionCity'];
        $result->jurisdictionState = $resource['jurisdictionState'];
        $result->jurisdictionCountry = $resource['jurisdictionCountry'] ? Country::fromResource($resource['jurisdictionCountry']) : null;

        return $result;
    }
}
