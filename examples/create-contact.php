<?php

declare(strict_types=1);

use PswGroup\Api\Model\Resource\AccountContact;
use PswGroup\Api\Repository\AccountContactRepository;
use PswGroup\Api\Repository\CountryRepository;
use PswGroup\Api\Repository\OrganisationTypeRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$client = include 'client.php';

$countryRepository = new CountryRepository($client);
$country = $countryRepository->load('DE');

$organisationTypeRepository = new OrganisationTypeRepository($client);
$organisationType = $organisationTypeRepository->load('2');

$contact = new AccountContact();
$contact->setSalutation('Mr.');
$contact->setFirstname('John');
$contact->setLastname('Doe');
$contact->setTelephone('+4966148027610');
$contact->setEmail('admin@ssl-test.de');
$contact->setAddressLine1('Flemingstraße 20-22');
$contact->setAddressLine2('');
$contact->setAddressLine3('');
$contact->setAddressZip('36041');
$contact->setAddressCity('Fulda');
$contact->setAddressState('Hessen');
$contact->setAddressCountry($country);
$contact->setOrganisationType($organisationType);
$contact->setOrganisationName('PSW GROUP GmbH & Co. KG');
$contact->setOrganisationUnit('Development');
$contact->setAllowedAsOrderContact(true);
$contact->setAllowedAsOwnerContact(false);

$contactRepository = new AccountContactRepository($client);
$contact = $contactRepository->save($contact);

outputParagraph('New contact number:  %s', $contact->getNumber());
