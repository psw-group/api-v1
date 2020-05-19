<?php

declare(strict_types=1);

use PswGroup\Api\Repository\AccountContactRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$contactRepository = new AccountContactRepository($client);
$contacts = $contactRepository->loadAll();

$list = [];

foreach ($contacts as $contact) {
    $list[] = [
        'firstname' => $contact->getFirstname(),
        'lastname' => $contact->getLastname(),
        'telephone' => $contact->getTelephone(),
        'email' => $contact->getEmail(),
    ];
}

outputParagraph('Found %d contacts.', count($contacts));
outputTable($list);
