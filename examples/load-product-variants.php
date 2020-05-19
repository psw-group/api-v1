<?php

declare(strict_types=1);

use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';

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

echo sprintf('Product %s has %d variants.%s', $parentProduct->getNumber(), count($products), PHP_EOL . PHP_EOL);
outputTable($list, ['price' => STR_PAD_LEFT]);

function outputTable(array $list, $padTypes = []): void
{
    if (count($list) === 0) {
        return;
    }

    $lengths = [];

    foreach (array_keys($list[0]) as $column) {
        $lengths[$column] = maxLength($list, $column);
    }

    $isFirst = true;

    foreach ($list as $row) {
        if ($isFirst) {
            $isFirst = false;

            foreach (array_keys($row) as $column) {
                echo '| ' . pad($column, $lengths[$column], ' ', $padTypes[$column] ?? STR_PAD_RIGHT) . ' ';
            }
            echo '|' . PHP_EOL;
        }

        foreach ($row as $column => $data) {
            echo '| ' . pad($data, $lengths[$column], ' ', $padTypes[$column] ?? STR_PAD_RIGHT) . ' ';
        }
        echo '|' . PHP_EOL;
    }
}

function maxLength(array $list, string $column): int
{
    $max = mb_strlen($column, 'UTF-8');

    foreach ($list as $row) {
        $length = mb_strlen((string) $row[$column], 'UTF-8');

        if ($length > $max) {
            $max = $length;
        }
    }

    return $max;
}

function pad(string $input, int $pad_length, string $pad_string = ' ', int $pad_type = STR_PAD_RIGHT)
{
    $mb_diff = strlen($input) - mb_strlen($input, 'UTF-8');

    return str_pad($input, $pad_length + $mb_diff, $pad_string, $pad_type);
}
