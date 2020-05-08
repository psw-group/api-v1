<?php

declare(strict_types=1);

namespace PswGroup\Test\Api\Unit\Model\DataTransferObject;

use PHPUnit\Framework\TestCase;
use PswGroup\Api\Model\DataTransferObject\CertificateRequest;
use PswGroup\Api\Model\DataTransferObject\ContactInput;
use PswGroup\Api\Model\DataTransferObject\CsrFieldsInput;
use PswGroup\Api\Model\DataTransferObject\ValidationInput;

class CertificateRequestTest extends TestCase
{
    /**
     * @var string
     */
    private static $csrFile = '-----BEGIN CERTIFICATE REQUEST-----
MIIC+jCCAeICAQAwZTELMAkGA1UEBhMCREUxDzANBgNVBAgTBkhlc3NlbjEOMAwG
A1UEBxMFRnVsZGExEjAQBgNVBAoTCVBTVyBHUk9VUDELMAkGA1UECxMCSVQxFDAS
BgNVBAMTC3NzbC10ZXN0LmRlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKC
AQEAoV5CtIMT2AUog45uiofJAbMviFK6viJ/4nFm9rM/49+tp4aPmslk9rUYHYlH
LXAtWs/xQi6Da5+h9RxDCWj8DFtANd3cvQEovMNe2EqXEIXZ027P6e2w+P3QlpYP
8uwSDiR4YjX6R40kj/wmeLG7cwbhXEQU8K9+PXjoM4XE3ARD9/n4VH5EFDEwAieE
GKIfd/bjbZpJCQ9A7wQVcQtvoWblQr655CCp4W/zeTXCQH/03wxK2melaLzXm6QS
tLiMn9p9LBtz4EfRIK8Vq8fZuGEJn+iP2rPcwVr0amfIWaZKVIeiTAr4TTb1U9Ao
8InNwpfkGY5w5V2G0RuRvx16awIDAQABoFAwTgYJKoZIhvcNAQkOMUEwPzA9BgNV
HREENjA0gg93d3cuc3NsLXRlc3QuZGWCFGJlaXNwaWVsLnNzbC10ZXN0LmRlggtz
c2wtdGVzdC5kZTANBgkqhkiG9w0BAQsFAAOCAQEAhB3lfuLHPygqovQSNKLu/rk0
3dPAVwz/MKA8ErNrddO1+d3PIN1CECwQPbVCWJ+RZO8FXC17Dj2EkfUfpA5DHJod
vzvUhWHccrUZOutxdTyfkIktuYB+Ax69j8mlVUWOLIyc4RDrRe14H0B3nOFL7ObM
p3a0X99+tHYlBDDf5HBuIWM12DzYGzYPz2KX8Pg1+K5NmOxQlfAMRGZgBioNDVxI
DeRo4DfL4zWynRDA2+8qIK5KE+05Dd+XV5fHnkV30Gt5Z17QpHAJA1BpSYixkcBa
7V7GRZEtfddTknh3ysDyifqyzHxYcNoe/RfRL5lckVpQTQ4vmIcCr8wGGMDANw==
-----END CERTIFICATE REQUEST-----';

    public function test_getters_and_setters(): void
    {
        $request = $this->buildRequest();

        $this->assertEquals(self::$csrFile, $request->getCsrFile());
        $this->assertEquals('username', $request->getUsername());
        $this->assertEquals('password', $request->getPassword());
        $this->assertEquals('SHA-2', $request->getHashAlgorithm());
        $this->assertEquals(2, $request->getServerCount());
        $this->assertEquals('ssl-test.de', $request->getCsrFields()->getCommonName());
        $this->assertEquals('PSW GROUP GmbH & Co. KG', $request->getOwnerContact()->getOrganisationName());
        $this->assertEquals('IT', $request->getApproverContact()->getOrganisationUnit());
        $this->assertCount(1, $request->getValidation());
        $this->assertEquals('ssl-test.de', $request->getValidation()[0]->getName());
    }

    public function test_is_serializable(): void
    {
        $request = $this->buildRequest();
        $serialized = json_encode($request);

        $expected = '{"csrFile":"-----BEGIN CERTIFICATE REQUEST-----\nMIIC+jCCAeICAQAwZTELMAkGA1UEBhMCREUxDzANBgNVBAgTBkhlc3NlbjEOMAwG\nA1UEBxMFRnVsZGExEjAQBgNVBAoTCVBTVyBHUk9VUDELMAkGA1UECxMCSVQxFDAS\nBgNVBAMTC3NzbC10ZXN0LmRlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKC\nAQEAoV5CtIMT2AUog45uiofJAbMviFK6viJ\/4nFm9rM\/49+tp4aPmslk9rUYHYlH\nLXAtWs\/xQi6Da5+h9RxDCWj8DFtANd3cvQEovMNe2EqXEIXZ027P6e2w+P3QlpYP\n8uwSDiR4YjX6R40kj\/wmeLG7cwbhXEQU8K9+PXjoM4XE3ARD9\/n4VH5EFDEwAieE\nGKIfd\/bjbZpJCQ9A7wQVcQtvoWblQr655CCp4W\/zeTXCQH\/03wxK2melaLzXm6QS\ntLiMn9p9LBtz4EfRIK8Vq8fZuGEJn+iP2rPcwVr0amfIWaZKVIeiTAr4TTb1U9Ao\n8InNwpfkGY5w5V2G0RuRvx16awIDAQABoFAwTgYJKoZIhvcNAQkOMUEwPzA9BgNV\nHREENjA0gg93d3cuc3NsLXRlc3QuZGWCFGJlaXNwaWVsLnNzbC10ZXN0LmRlggtz\nc2wtdGVzdC5kZTANBgkqhkiG9w0BAQsFAAOCAQEAhB3lfuLHPygqovQSNKLu\/rk0\n3dPAVwz\/MKA8ErNrddO1+d3PIN1CECwQPbVCWJ+RZO8FXC17Dj2EkfUfpA5DHJod\nvzvUhWHccrUZOutxdTyfkIktuYB+Ax69j8mlVUWOLIyc4RDrRe14H0B3nOFL7ObM\np3a0X99+tHYlBDDf5HBuIWM12DzYGzYPz2KX8Pg1+K5NmOxQlfAMRGZgBioNDVxI\nDeRo4DfL4zWynRDA2+8qIK5KE+05Dd+XV5fHnkV30Gt5Z17QpHAJA1BpSYixkcBa\n7V7GRZEtfddTknh3ysDyifqyzHxYcNoe\/RfRL5lckVpQTQ4vmIcCr8wGGMDANw==\n-----END CERTIFICATE REQUEST-----","csrFields":{"commonName":"ssl-test.de","countryName":null,"stateOrProvinceName":null,"localityName":null,"organisationName":null,"organisationalUnitName":null,"emailAddress":null,"sans":null},"validation":[{"name":"ssl-test.de","method":"email","email":"webmaster@ssl-test.de"}],"username":"username","password":"password","hashAlgorithm":"SHA-2","serverCount":2,"ownerContact":{"contact":null,"storeData":false,"salutation":null,"firstname":null,"lastname":null,"telephone":null,"email":null,"addressLine1":null,"addressLine2":null,"addressLine3":null,"addressZip":null,"addressCity":null,"addressState":null,"addressCountry":null,"organisationType":null,"organisationName":"PSW GROUP GmbH & Co. KG","organisationUnit":null,"organisationDuns":null,"jurisdictionAgency":null,"jurisdictionNumber":null,"jurisdictionCity":null,"jurisdictionState":null,"jurisdictionCountry":null},"approverContact":{"contact":null,"storeData":false,"salutation":null,"firstname":null,"lastname":null,"telephone":null,"email":null,"addressLine1":null,"addressLine2":null,"addressLine3":null,"addressZip":null,"addressCity":null,"addressState":null,"addressCountry":null,"organisationType":null,"organisationName":null,"organisationUnit":"IT","organisationDuns":null,"jurisdictionAgency":null,"jurisdictionNumber":null,"jurisdictionCity":null,"jurisdictionState":null,"jurisdictionCountry":null}}';

        $this->assertEquals($expected, $serialized);
    }

    private function buildRequest(): CertificateRequest
    {
        $fields = new CsrFieldsInput();
        $fields->setCommonName('ssl-test.de');

        $ownerContact = new ContactInput();
        $ownerContact->setOrganisationName('PSW GROUP GmbH & Co. KG');

        $approverContact = new ContactInput();
        $approverContact->setOrganisationUnit('IT');

        $result = new CertificateRequest();
        $result->setCsrFile(self::$csrFile);
        $result->setCsrFields($fields);
        $result->setValidation([new ValidationInput('ssl-test.de', ValidationInput::METHOD_EMAIL, 'webmaster@ssl-test.de')]);
        $result->setUsername('username');
        $result->setPassword('password');
        $result->setHashAlgorithm('SHA-2');
        $result->setServerCount(2);
        $result->setOwnerContact($ownerContact);
        $result->setApproverContact($approverContact);

        return $result;
    }
}
