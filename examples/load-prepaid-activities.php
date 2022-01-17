<?php

declare(strict_types=1);

use PswGroup\Api\Repository\PrepaidActivityRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$prepaidActivityRepository = new PrepaidActivityRepository($client);
$items = $prepaidActivityRepository->loadAll();

$list = [];

foreach ($items as $item) {
    $list[] = [
        'createdAt' => $item->getCreatedAt()->format('Y-m-d H:i'),
        'amount' => number_format($item->getAmount(), 2) . ' ' . $item->getCurrency()->getIso3(),
        'reference' => $item->getReference(),
    ];
}

outputParagraph('There are %s activities.', count($items));
outputTable($list, ['amount' => STR_PAD_LEFT]);
