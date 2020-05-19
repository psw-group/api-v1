<?php

declare(strict_types=1);

use PswGroup\Api\Repository\OrderRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$orderRepository = new OrderRepository($client);
$orders = $orderRepository->loadAll();

$list = [];

foreach ($orders as $order) {
    $list[] = [
        'number' => $order->getNumber(),
        'orderedAt' => $order->getCreatedAt()->format('Y-m-d'),
        'state' => $order->getState()->getCode(),
    ];
}

outputParagraph('Found %d orders.', count($orders));
outputTable($list);
