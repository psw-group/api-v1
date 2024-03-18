<?php

declare(strict_types=1);

use PswGroup\Api\Model\Resource\Client;
use PswGroup\Api\Repository\AccountRepository;
use PswGroup\Api\Repository\ClientRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';

$apiClient = include 'client.php';

$accountRepository = new AccountRepository($apiClient);
$accounts = $accountRepository->loadAll();
$account = $accounts[0];

$client = new Client();
$client->setAccount($account);
$client->setName('Test application');
$client->setWebhookType('json');
$client->setWebhookUrl(null);
$client->setIpAddresses(['127.0.0.1']);
$client->setEmailsEnabled(false);

$clientRepository = new ClientRepository($apiClient);
$client = $clientRepository->save($client);

outputParagraph('New client number:  %s' . PHP_EOL . 'Client id: %s' . PHP_EOL . 'Client secret: %s', $client->getNumber(), $client->getClientId(), $client->getClientSecret());
