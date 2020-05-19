<?php

declare(strict_types=1);

use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$productRepository = new ProductRepository($client);
$parentProduct = $productRepository->load('A001023');

$products = $productRepository->loadVariants($parentProduct);

$list = [];

foreach ($products as $product) {
    if (! $product->isOrderable()) {
        continue;
    }

    $list[] = [
        'number' => $product->getNumber(),
        'name' => $product->getName(),
        'ca' => $product->getCa()->getName(),
        'price' => number_format($product->getPriceGross(), 2) . ' ' . $product->getCurrency()->getIso3(),
    ];
}

outputParagraph('Product %s has %d variants.', $parentProduct->getNumber(), count($products));
outputTable($list, ['price' => STR_PAD_LEFT]);
