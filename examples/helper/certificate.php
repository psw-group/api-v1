<?php

declare(strict_types=1);

use PswGroup\Api\Model\Resource\Certificate;
use PswGroup\Api\Repository\CertificateRepository;

function loadRandomCertificate(CertificateRepository $certificateRepository): Certificate
{
    $certificates = $certificateRepository->loadAll()->getItems();

    if (count($certificates) === 0) {
        outputParagraph('No certificates found.');

        exit;
    }

    shuffle($certificates);

    return $certificates[0];
}

function loadRandomValidCertificate(CertificateRepository $certificateRepository): Certificate
{
    $certificates = $certificateRepository->loadAll()->getItems();

    if (count($certificates) === 0) {
        outputParagraph('No certificates found.');

        exit;
    }

    $validCertificates = array_filter(
        $certificates,
        static function (Certificate $certificate) {
            return $certificate->getState()->getCode() === 'valid';
        }
    );

    if (count($validCertificates) === 0) {
        outputParagraph('No valid certificates found.');

        exit;
    }

    shuffle($validCertificates);

    return $validCertificates[0];
}
