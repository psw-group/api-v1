<?php

declare(strict_types=1);

use PswGroup\Api\Repository\PrepaidActivityRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$prepaidActivityRepository = new PrepaidActivityRepository($client);
$item = $prepaidActivityRepository->recharge(100);

outputParagraph('You will receive an invoice for your new activity with reference %s.', $item->getReference());
