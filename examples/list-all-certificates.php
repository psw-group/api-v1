<?php

declare(strict_types=1);

use PswGroup\Api\Repository\CertificateRepository;

include '../vendor/autoload.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$certificateRepository = new CertificateRepository($client);
$certificates = $certificateRepository->loadAll();

$list = [];

foreach ($certificates as $certificate) {
    $list[] = [
        'number' => $certificate->getNumber(),
        'name' => $certificate->getName(),
        'ca' => $certificate->getCa()->getName(),
        'state' => $certificate->getState()->getCode(),
        'validTo' => $certificate->getValidTo() !== null ? $certificate->getValidTo()->format('Y-m-d') : '',
    ];
}

outputParagraph('Found %d certificates.', count($certificates));
outputTable($list);

