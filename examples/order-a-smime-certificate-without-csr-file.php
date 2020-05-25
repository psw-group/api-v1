<?php

declare(strict_types=1);

use PswGroup\Api\Model\Request\CertificateData;
use PswGroup\Api\Model\Request\Contact;
use PswGroup\Api\Model\Request\CsrFields;
use PswGroup\Api\Model\Request\OrderItem;
use PswGroup\Api\Model\Request\OrderRequest;
use PswGroup\Api\Repository\OrderRepository;
use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$client = include 'client.php';

// Build a certificate request
$csrFields = new CsrFields();
$csrFields->setEmailAddress('mail@ssl-test.de');
$csrFields->setCountryName('DE');

$ownerContact = new Contact();
$ownerContact->setFirstname('API');
$ownerContact->setLastname('User');
$ownerContact->setTelephone('+4966148027610');

$certificateData = new CertificateData();
$certificateData->setCsrFields($csrFields);
$certificateData->setOwnerContact($ownerContact);
$certificateData->setPassword('Password1234');

// Load a product: GlobalSign Personal Sign 1, 3 years
$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000751');

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
