<?php

declare(strict_types=1);

use PswGroup\Api\Repository\AccountRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$accountRepository = new AccountRepository($client);
$accounts = $accountRepository->loadAll();

$list = [];

foreach ($accounts as $account) {
    $list[] = [
        'number' => $account->getNumber(),
        'name' => $account->getName(),
        'customer number' => $account->getCustomerNumber() ?: '',
        'language' => $account->getLanguage()->getIso2(),
        'main' => $account->isMain() ? 'true' : 'false',
        'invoices' => $account->receiveInvoices() ? 'true' : 'false',
    ];
}

outputParagraph('Found %d accounts.', count($accounts));
outputTable($list);
