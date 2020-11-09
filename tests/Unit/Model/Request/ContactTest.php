<?php

declare(strict_types=1);

namespace PswGroup\Test\Api\Unit\Model\Request;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PswGroup\Api\Model\Request\Contact;
use PswGroup\Api\Model\Resource\AccountContact;
use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

class ContactTest extends TestCase
{
    public function test_getters_and_setters(): void
    {
        $contact = $this->buildContact();

        $this->assertEquals('Mr.', $contact->getSalutation());
        $this->assertEquals('API', $contact->getFirstname());
        $this->assertEquals('Tester', $contact->getLastname());
        $this->assertEquals('+4966148027610', $contact->getTelephone());
        $this->assertEquals('admin@ssl-test.de', $contact->getEmail());
        $this->assertEquals('Flemingstraße 20-22', $contact->getAddressLine1());
        $this->assertEquals('', $contact->getAddressLine2());
        $this->assertEquals('', $contact->getAddressLine3());
        $this->assertEquals('36041', $contact->getAddressZip());
        $this->assertEquals('Fulda', $contact->getAddressCity());
        $this->assertEquals('Hessen', $contact->getAddressState());
        $this->assertEquals('DE', $contact->getAddressCountry()->getIso2());
        $this->assertEquals('2', $contact->getOrganisationType()->getCode());
        $this->assertEquals('PSW GROUP GmbH & Co. KG', $contact->getOrganisationName());
        $this->assertEquals('Development', $contact->getOrganisationUnit());
        $this->assertEquals('53-747-3485', $contact->getOrganisationDuns());
        $this->assertEquals('Amtsgericht Fulda', $contact->getJurisdictionAgency());
        $this->assertEquals('HRA 5007', $contact->getJurisdictionNumber());
        $this->assertEquals('Fulda', $contact->getJurisdictionCity());
        $this->assertEquals('Hessen', $contact->getJurisdictionState());
        $this->assertEquals('DE', $contact->getJurisdictionCountry()->getIso2());

        $this->assertEquals('Mr.', $contact->getContact()->getSalutation());
        $this->assertEquals('API', $contact->getContact()->getFirstname());
        $this->assertEquals('Tester', $contact->getContact()->getLastname());

        $this->assertFalse($contact->getStoreData());
    }

    public function provideLargeData(): array
    {
        return [
            'salutation' => ['setSalutation', str_repeat('X', 256)],
            'firstname' => ['setFirstname', str_repeat('X', 256)],
            'lastname' => ['setLastname', str_repeat('X', 256)],
            'telephone' => ['setTelephone', str_repeat('X', 256)],
            'email' => ['setEmail', str_repeat('X', 256) . '@' . str_repeat('X', 256)],
            'addressLine1' => ['setAddressLine1', str_repeat('X', 256)],
            'addressLine2' => ['setAddressLine2', str_repeat('X', 256)],
            'addressLine3' => ['setAddressLine3', str_repeat('X', 256)],
            'addressZip' => ['setAddressZip', str_repeat('X', 256)],
            'addressCity' => ['setAddressCity', str_repeat('X', 256)],
            'addressState' => ['setAddressState', str_repeat('X', 256)],
            'organisationName' => ['setOrganisationName', str_repeat('X', 256)],
            'organisationUnit' => ['setOrganisationUnit', str_repeat('X', 256)],
            'organisationDuns' => ['setOrganisationDuns', str_repeat('X', 256)],
            'jurisdictionAgency' => ['setJurisdictionAgency', str_repeat('X', 256)],
            'jurisdictionNumber' => ['setJurisdictionNumber', str_repeat('X', 256)],
            'jurisdictionCity' => ['setJurisdictionCity', str_repeat('X', 256)],
            'jurisdictionState' => ['setJurisdictionState', str_repeat('X', 256)],
        ];
    }

    /**
     * @dataProvider provideLargeData
     */
    public function test_validates_large_data(string $method, string $data): void
    {
        $this->expectException(InvalidArgumentException::class);

        $contact = $this->buildContact();
        $contact->{$method}($data);
    }

    public function provideInvalidEmailAdresses(): array
    {
        return [
            ['@@'],
            ['foo@'],
            ['@bar'],
        ];
    }

    /**
     * @dataProvider provideInvalidEmailAdresses
     */
    public function test_validates_email_adress(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        $contact = $this->buildContact();
        $contact->setEmail($name);
    }

    public function provideInvalidTelephone(): array
    {
        return [
            ['+'],
            ['+49'],
            ['123456789a'],
            ['12345+6789'],
            ['123456789123456789'],
        ];
    }

    /**
     * @dataProvider provideInvalidTelephone
     */
    public function test_validates_telephone(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        $contact = $this->buildContact();
        $contact->setTelephone($name);
    }

    public function test_converts_empty_strings_to_null(): void
    {
        $contact = $this->buildContact();
        $contact->setTelephone('');
        $contact->setEmail('');
        $this->assertNull($contact->getTelephone());
        $this->assertNull($contact->getEmail());
    }

    public function test_is_serializable(): void
    {
        $contact = $this->buildContact();
        $serialized = json_encode($contact);

        $expected = '{"contact":null,"storeData":false,"salutation":"Mr.","firstname":"API","lastname":"Tester","telephone":"+4966148027610","email":"admin@ssl-test.de","addressLine1":"Flemingstra\u00dfe 20-22","addressLine2":"","addressLine3":"","addressZip":"36041","addressCity":"Fulda","addressState":"Hessen","addressCountry":null,"organisationType":null,"organisationName":"PSW GROUP GmbH & Co. KG","organisationUnit":"Development","organisationDuns":"53-747-3485","jurisdictionAgency":"Amtsgericht Fulda","jurisdictionNumber":"HRA 5007","jurisdictionCity":"Fulda","jurisdictionState":"Hessen","jurisdictionCountry":null}';

        $this->assertEquals($expected, $serialized);
    }

    private function buildContact(): Contact
    {
        $result = new Contact();

        $result->setSalutation('Mr.');
        $result->setFirstname('API');
        $result->setLastname('Tester');
        $result->setTelephone('+4966148027610');
        $result->setEmail('admin@ssl-test.de');
        $result->setAddressLine1('Flemingstraße 20-22');
        $result->setAddressLine2('');
        $result->setAddressLine3('');
        $result->setAddressZip('36041');
        $result->setAddressCity('Fulda');
        $result->setAddressState('Hessen');
        $result->setAddressCountry(new Country('DE'));
        $result->setOrganisationType(new OrganisationType('2', 'Im Handelsregister eingetragene Firma'));
        $result->setOrganisationName('PSW GROUP GmbH & Co. KG');
        $result->setOrganisationUnit('Development');
        $result->setOrganisationDuns('53-747-3485');
        $result->setJurisdictionAgency('Amtsgericht Fulda');
        $result->setJurisdictionNumber('HRA 5007');
        $result->setJurisdictionCity('Fulda');
        $result->setJurisdictionState('Hessen');
        $result->setJurisdictionCountry(new Country('DE'));

        $accountContact = new AccountContact();
        $accountContact->setSalutation('Mr.');
        $accountContact->setFirstname('API');
        $accountContact->setLastname('Tester');

        $result->setContact($accountContact);
        $result->setStoreData(false);

        return $result;
    }
}
