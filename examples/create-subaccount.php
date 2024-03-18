<?php

declare(strict_types=1);

use PswGroup\Api\Model\DataTransferObject\InvoiceContact;
use PswGroup\Api\Model\Resource\Account;
use PswGroup\Api\Repository\AccountRepository;
use PswGroup\Api\Repository\CountryRepository;
use PswGroup\Api\Repository\LanguageRepository;
use PswGroup\Api\Repository\OrganisationTypeRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$client = include 'client.php';

$countryRepository = new CountryRepository($client);
$country = $countryRepository->load('DE');

$languageRepository = new LanguageRepository($client);
$language = $languageRepository->load('de');

$organisationTypeRepository = new OrganisationTypeRepository($client);
$organisationType = $organisationTypeRepository->load('2');

$contact = new InvoiceContact();
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

$account = new Account();
$account->setInvoiceContact($contact);
$account->setLanguage($language);
$account->setReceiveInvoices(false);

$accountRepository = new AccountRepository($client);
$account = $accountRepository->save($account);

outputParagraph('New account number:  %s', $account->getNumber());
