<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use JsonSerializable;

/**
 * Represents an invoice contact of an account.
 */
class InvoiceContact extends EmbeddedContact implements JsonSerializable
{
    use WritableContact;

    /**
     * @return array{salutation: string|null, firstname: string|null, lastname: string|null, telephone: string|null, email: string|null, addressLine1: string|null, addressLine2: string|null, addressLine3: string|null, addressZip: string|null, addressCity: string|null, addressState: string|null, addressCountry: string|null, organisationType: string|null, organisationName: string|null, organisationUnit: string|null, organisationDuns: string|null, jurisdictionAgency: string|null, jurisdictionNumber: string|null, jurisdictionCity: string|null, jurisdictionState: string|null, jurisdictionCountry: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'salutation' => $this->salutation,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'addressLine3' => $this->addressLine3,
            'addressZip' => $this->addressZip,
            'addressCity' => $this->addressCity,
            'addressState' => $this->addressState,
            'addressCountry' => $this->addressCountry?->getIri(),
            'organisationType' => $this->organisationType?->getIri(),
            'organisationName' => $this->organisationName,
            'organisationUnit' => $this->organisationUnit,
            'organisationDuns' => $this->organisationDuns,
            'jurisdictionAgency' => $this->jurisdictionAgency,
            'jurisdictionNumber' => $this->jurisdictionNumber,
            'jurisdictionCity' => $this->jurisdictionCity,
            'jurisdictionState' => $this->jurisdictionState,
            'jurisdictionCountry' => $this->jurisdictionCountry?->getIri(),
        ];
    }
}
