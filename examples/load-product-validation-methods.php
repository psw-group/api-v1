<?php

declare(strict_types=1);

use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000547');
$methods = $productRepository->loadValidationMethods($product);

$list = [];

foreach ($methods as $field) {
    $list[] = [
        'code' => $field->getCode(),
        'name' => $field->getName(),
    ];
}

outputParagraph('Product %s has %d possible validation methods.', $product->getNumber(), count($methods));
outputTable($list);
