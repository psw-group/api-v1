<?php

declare(strict_types=1);

use PswGroup\Api\Model\Request\CertificateData;
use PswGroup\Api\Model\Request\CsrFields;
use PswGroup\Api\Model\Request\QuoteItem;
use PswGroup\Api\Model\Request\QuoteRequest;
use PswGroup\Api\Repository\ProductRepository;
use PswGroup\Api\Repository\QuoteRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$client = include 'client.php';

// Build a certificate request
$csrFields = new CsrFields();
$csrFields->setCommonName('ssl-test.de');
$csrFields->setCountryName('DE');
$csrFields->setSans(['www.ssl-test.de', 'dev.ssl-test.de', 'stage.ssl-test.de', 'prod.ssl-test.de']);

$certificateData = new CertificateData();
$certificateData->setCsrFields($csrFields);

//Load a product: SECTIGO New Silver Multidomain 1 year
$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000031');

// Build a quote item
$quoteItem = new QuoteItem();
$quoteItem->setProduct($product);
$quoteItem->setCertificateData($certificateData);

// Build a quote request
$quoteRequest = new QuoteRequest();
$quoteRequest->addItem($quoteItem);

// Get a quote
$quoteRepository = new QuoteRepository($client);
$quote = $quoteRepository->quote($quoteRequest);

outputParagraph('Product: %s' . PHP_EOL . 'Base price: %s', $product->getNumber(), number_format($product->getPriceGross(), 2) . ' ' . $product->getCurrency()->getIso3());
outputParagraph('Common name: %s' . PHP_EOL . 'SANs: %s', $csrFields->getCommonName(), implode(', ', $csrFields->getSans()));
outputParagraph('Price including addons: %s', number_format($quote->getPriceGross(), 2) . ' ' . $quote->getCurrency()->getIso3());
