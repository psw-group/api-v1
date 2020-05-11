<?php

declare(strict_types=1);

use PswGroup\Api\GenericClient;
use PswGroup\Api\Model\DataTransferObject\CertificateRequest;
use PswGroup\Api\Model\DataTransferObject\ContactInput;
use PswGroup\Api\Model\DataTransferObject\CsrFieldsInput;
use PswGroup\Api\Model\DataTransferObject\OrderItemInput;
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
$csrFields = new CsrFieldsInput();
$csrFields->setEmailAddress('mail@ssl-test.de');
$csrFields->setCountryName('DE');

$ownerContact = new ContactInput();
$ownerContact->setFirstname('API');
$ownerContact->setLastname('User');
$ownerContact->setTelephone('+4966148027610');

$certificateRequest = new CertificateRequest();
$certificateRequest->setCsrFields($csrFields);
$certificateRequest->setOwnerContact($ownerContact);
$certificateRequest->setPassword('Password1234');

// Load a product: GlobalSign Personal Sign 1, 3 years
$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000751');

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
