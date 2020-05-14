<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;

class CertificateCsrFields
{
    use CsrFieldsData;

    public static function fromResource(HalResource $resource): self
    {
        $result = new self();

        $result->commonName = $resource->getProperty('commonName');
        $result->countryName = $resource->getProperty('countryName');
        $result->stateOrProvinceName = $resource->getProperty('stateOrProvinceName');
        $result->localityName = $resource->getProperty('localityName');
        $result->organisationName = $resource->getProperty('organisationName');
        $result->organisationalUnitName = $resource->getProperty('organisationalUnitName');
        $result->emailAddress = $resource->getProperty('emailAddress');
        $result->sans = $resource->getProperty('sans');

        return $result;
    }
}
