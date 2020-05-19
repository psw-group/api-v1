<?php

declare(strict_types=1);

use PswGroup\Api\Repository\ProductRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$productRepository = new ProductRepository($client);
$product = $productRepository->load('A000547');
$fields = $productRepository->loadOrderFields($product);

$list = [];

foreach ($fields as $field) {
    $entry = [
        'path' => $field->getPath(),
        'required' => 'false',
        'optional' => 'false',
        'length' => '',
        'regex' => '',
    ];

    foreach ($field->getConstraints() as $constraint) {
        switch ($constraint->getType()) {
            case 'required':
                $entry['required'] = $constraint->getParameters()['value'] ? 'true' : 'false';

                break;

            case 'optional':
                $entry['optional'] = $constraint->getParameters()['value'] ? 'true' : 'false';

                break;

            case 'length':
                $entry['length'] = ($constraint->getParameters()['min'] ?? 0) . ' - ' . $constraint->getParameters()['max'];

                break;

            case 'regex':
                $entry['regex'] = substr($constraint->getParameters()['value'], 0, 30) . (strlen($constraint->getParameters()['value']) > 30 ? '...' : '');

                break;
        }
    }
    $list[] = $entry;
}

outputParagraph('Product %s has %d defined fields.', $product->getNumber(), count($fields));
outputTable($list);
