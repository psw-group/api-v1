<?php

declare(strict_types=1);

use PswGroup\Api\Repository\OrderRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$orderRepository = new OrderRepository($client);
$orders = $orderRepository->loadAll()->getItems();

if (count($orders) === 0) {
    outputParagraph('No orders found.');

    exit;
}

shuffle($orders);
$order = $orders[0];

$items = $orderRepository->loadItems($order);

$list = [];

foreach ($items as $item) {
    $list[] = [
        'sku' => $item->getProductNumber(),
        'name' => $item->getProductName(),
        'quantity' => number_format($item->getQuantity(), 0),
        'price' => number_format($item->getRowPriceGross(), 2) . ' ' . $order->getCurrency()->getIso3(),
    ];
}

outputParagraph('Order %s has %d item(s).', $order->getNumber(), count($items));
outputTable($list, ['price' => STR_PAD_LEFT]);
