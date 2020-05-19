<?php

declare(strict_types=1);

use PswGroup\Api\Repository\CertificateRepository;

include '../vendor/autoload.php';
include 'helper/certificate.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$certificateRepository = new CertificateRepository($client);
$certificate = loadRandomValidCertificate($certificateRepository);

$key = $certificateRepository->loadKey($certificate);
$items = $certificateRepository->loadChain($certificate);

$list = [];

foreach ($items as $item) {
    $list[] = [
        'name' => $item->getCommonName(),
        'serial' => $item->getSerialNumber(),
    ];
}

outputParagraph('Key for certificate %s:', $certificate->getNumber());
outputParagraph($key->getContent());
outputParagraph('Chain for certificate %s:', $certificate->getNumber());
outputTable($list);
