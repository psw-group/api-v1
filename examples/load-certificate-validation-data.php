<?php

declare(strict_types=1);

use PswGroup\Api\Repository\CertificateRepository;

include '../vendor/autoload.php';
include 'helper/certificate.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$certificateRepository = new CertificateRepository($client);
$certificate = loadRandomCertificate($certificateRepository);

$items = $certificateRepository->loadValidationData($certificate);

$list = [];

foreach ($items as $item) {
    $list[] = [
        'domain' => $item->getDomain(),
        'method' => $item->getMethod()->getName(),
        'data' => json_encode($item->getData()),
    ];
}

outputParagraph('Certificate %s has %d validation data entries.', $certificate->getNumber(), count($items));
outputTable($list);
