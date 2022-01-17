<?php

declare(strict_types=1);

use PswGroup\Api\Repository\PrepaidAccountRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$prepaidAccountRepository = new PrepaidAccountRepository($client);
$prepaidAccount = $prepaidAccountRepository->load();

if ($prepaidAccount !== null) {
    outputParagraph('The balance of the prepaid account is: %d', $prepaidAccount->getBalance());
} else {
    outputParagraph('There is no prepaid account.');
}
