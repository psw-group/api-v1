<?php

declare(strict_types=1);

use PswGroup\Api\GenericClient;
use PswGroup\Api\Model\DataTransferObject\CertificateRequest;
use PswGroup\Api\Model\DataTransferObject\ContactInput;
use PswGroup\Api\Model\DataTransferObject\CsrFieldsInput;
use PswGroup\Api\Model\DataTransferObject\OrderItemInput;
use PswGroup\Api\Model\DataTransferObject\ValidationInput;
use PswGroup\Api\Model\Request\OrderRequest;
use PswGroup\Api\Repository\OrderRepository;
use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';

$client = new GenericClient(
    'https://test-api.psw-group.de/v1',
    '[yourClientId]',
    '[yourClientSecret]'
);

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

$csrFields = new CsrFieldsInput();
$csrFields->setCommonName('ssl-test.de');
$csrFields->setCountryName('DE');

$certificateRequest = new CertificateRequest();
$certificateRequest->setCsrFile($csrFile);
$certificateRequest->setCsrFields($csrFields);
$certificateRequest->setValidation(
    [
        new ValidationInput('ssl-test.de', ValidationInput::METHOD_EMAIL, 'webmaster@ssl-test.de'),
    ]
);

//Load a product: SECTIGO Lite (30 day trial)
$productRepository = new ProductRepository($client);
$product = $productRepository->load('A001139');

// Build an order item
$orderItem = new OrderItemInput();
$orderItem->setProduct($product);
$orderItem->setCertificateRequest($certificateRequest);

// Build an order request
$orderContact = new ContactInput();
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

echo 'New order number: ' . $order->getNumber();
