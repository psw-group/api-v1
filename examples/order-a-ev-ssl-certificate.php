<?php

declare(strict_types=1);

use PswGroup\Api\Model\Request\CertificateData;
use PswGroup\Api\Model\Request\Contact;
use PswGroup\Api\Model\Request\CsrFields;
use PswGroup\Api\Model\Request\OrderItem;
use PswGroup\Api\Model\Request\OrderRequest;
use PswGroup\Api\Model\Request\Validation;
use PswGroup\Api\Repository\CountryRepository;
use PswGroup\Api\Repository\OrderRepository;
use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$client = include 'client.php';

// Build a certificate request
$csrFile = '-----BEGIN CERTIFICATE REQUEST-----
MIIC+jCCAeICAQAwZTELMAkGA1UEBhMCREUxDzANBgNVBAgTBkhlc3NlbjEOMAwG
A1UEBxMFRnVsZGExEjAQBgNVBAoTCVBTVyBHUk9VUDELMAkGA1UECxMCSVQxFDAS
BgNVBAMTC3NzbC10ZXN0LmRlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKC
AQEAoV5CtIMT2AUog45uiofJAbMviFK6viJ/4nFm9rM/49+tp4aPmslk9rUYHYlH
LXAtWs/xQi6Da5+h9RxDCWj8DFtANd3cvQEovMNe2EqXEIXZ027P6e2w+P3QlpYP
8uwSDiR4YjX6R40kj/wmeLG7cwbhXEQU8K9+PXjoM4XE3ARD9/n4VH5EFDEwAieE
GKIfd/bjbZpJCQ9A7wQVcQtvoWblQr655CCp4W/zeTXCQH/03wxK2melaLzXm6QS
tLiMn9p9LBtz4EfRIK8Vq8fZuGEJn+iP2rPcwVr0amfIWaZKVIeiTAr4TTb1U9Ao
8InNwpfkGY5w5V2G0RuRvx16awIDAQABoFAwTgYJKoZIhvcNAQkOMUEwPzA9BgNV
HREENjA0gg93d3cuc3NsLXRlc3QuZGWCFGJlaXNwaWVsLnNzbC10ZXN0LmRlggtz
c2wtdGVzdC5kZTANBgkqhkiG9w0BAQsFAAOCAQEAhB3lfuLHPygqovQSNKLu/rk0
3dPAVwz/MKA8ErNrddO1+d3PIN1CECwQPbVCWJ+RZO8FXC17Dj2EkfUfpA5DHJod
vzvUhWHccrUZOutxdTyfkIktuYB+Ax69j8mlVUWOLIyc4RDrRe14H0B3nOFL7ObM
p3a0X99+tHYlBDDf5HBuIWM12DzYGzYPz2KX8Pg1+K5NmOxQlfAMRGZgBioNDVxI
DeRo4DfL4zWynRDA2+8qIK5KE+05Dd+XV5fHnkV30Gt5Z17QpHAJA1BpSYixkcBa
7V7GRZEtfddTknh3ysDyifqyzHxYcNoe/RfRL5lckVpQTQ4vmIcCr8wGGMDANw==
-----END CERTIFICATE REQUEST-----';

$countryRepository = new CountryRepository($client);
$country = $countryRepository->load('DE');

$csrFields = new CsrFields();
$csrFields->setCommonName('ssl-test.de');
$csrFields->setCountryName('DE');

// Generate an owner of the certificate
$ownerContact = new Contact();
$ownerContact->setOrganisationName('PSW GROUP GmbH & Co. KG');
$ownerContact->setAddressLine1('Flemingstraße 20-22');
$ownerContact->setAddressZip('36041');
$ownerContact->setAddressCity('Fulda');
$ownerContact->setAddressState('Hessen');
$ownerContact->setAddressCountry($country);

// Generate a contact who will approve the certificate
$approverContact = new Contact();
$approverContact->setFirstname('API');
$approverContact->setLastname('Approver');
$approverContact->setEmail('mail@ssl-test.de');
$approverContact->setTelephone('+4966148027610');

$certificateData = new CertificateData();
$certificateData->setCsrFile($csrFile);
$certificateData->setCsrFields($csrFields);
$certificateData->setOwnerContact($ownerContact);
$certificateData->setApproverContact($approverContact);
$certificateData->setValidation(
    [
        new Validation('ssl-test.de', Validation::METHOD_EMAIL, 'webmaster@ssl-test.de'),
    ]
);

//Load a product: SECTIGO EV
$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000278');

// Build an order item
$orderItem = new OrderItem();
$orderItem->setProduct($product);
$orderItem->setCertificateData($certificateData);

// Build an order request
$orderContact = new Contact();
$orderContact->setSalutation('Mr.');
$orderContact->setFirstname('API');
$orderContact->setLastname('User');
$orderContact->setOrganisationName('PSW GROUP GmbH & Co. KG');
$orderContact->setEmail('mail@ssl-test.de');
$orderContact->setTelephone('+4966148027610');

$orderRequest = new OrderRequest();
$orderRequest->addItem($orderItem);
$orderRequest->setOrderContact($orderContact);

// Order the item
$orderRepository = new OrderRepository($client);
$order = $orderRepository->order($orderRequest);

outputParagraph('New order number: %s', $order->getNumber());
