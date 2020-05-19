<?php

declare(strict_types=1);

use PswGroup\Api\Model\Resource\CertificateValidationMethod;
use PswGroup\Api\Repository\CertificateRepository;

include '../vendor/autoload.php';
include 'helper/certificate.php';
include 'helper/paragraph.php';
include 'helper/table.php';

$client = include 'client.php';

$certificateRepository = new CertificateRepository($client);
$certificate = loadRandomCertificate($certificateRepository);

$items = $certificateRepository->loadValidationMethods($certificate);

$list = [];

foreach ($items as $item) {
    $list[] = [
        'domain' => $item->getDomain(),
        'methods' => json_encode(array_map(
            static function (CertificateValidationMethod $method) {
                return $method->getCode();
            },
            $item->getMethods()
        )),
        'emails' => json_encode($item->getEmailAddresses()),
    ];
}

outputParagraph('Certificate %s has %d validation data entries.', $certificate->getNumber(), count($items));
outputTable($list);
