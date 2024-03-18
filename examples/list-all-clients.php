<?php

declare(strict_types=1);

use PswGroup\Api\Repository\ClientRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$clientRepository = new ClientRepository($client);
$clients = $clientRepository->loadAll();

$list = [];

foreach ($clients as $client) {
    $list[] = [
        'number' => $client->getNumber(),
        'name' => $client->getName(),
        'client id' => $client->getClientId(),
        'account' => $client->getAccount()->getNumber() ?: '',
    ];
}

outputParagraph('Found %d clients.', count($clients));
outputTable($list);
