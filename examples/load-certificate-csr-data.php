<?php

declare(strict_types=1);

use PswGroup\Api\Repository\CertificateRepository;

include '../vendor/autoload.php';
include 'helper/certificate.php';
include 'helper/paragraph.php';

$client = include 'client.php';

$certificateRepository = new CertificateRepository($client);
$certificate = loadRandomCertificate($certificateRepository);

$file = $certificateRepository->loadCsrFile($certificate);

if ($file !== null) {
    outputParagraph('CSR file for certificate %s', $certificate->getNumber());
    outputParagraph($file->getContent());
} else {
    outputParagraph('Certificate %s has no CSR file.', $certificate->getNumber());
}

$fields = $certificateRepository->loadCsrFields($certificate);

if ($fields !== null) {
    outputParagraph('CSR fields for certificate %s', $certificate->getNumber());
    outputParagraph('Common name: %s%sEmail address: %s', $fields->getCommonName(), PHP_EOL, $fields->getEmailAddress());
} else {
    outputParagraph('Certificate %s has no CSR fields.', $certificate->getNumber());
}
