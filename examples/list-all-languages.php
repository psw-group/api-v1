<?php

declare(strict_types=1);

use PswGroup\Api\Repository\LanguageRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$languageRepository = new LanguageRepository($client);
$languages = $languageRepository->loadAll();

$list = [];

foreach ($languages as $language) {
    $list[] = [
        'ISO2' => $language->getIso2(),
    ];
}

outputParagraph('Found %d languages.', count($languages));
outputTable($list);
