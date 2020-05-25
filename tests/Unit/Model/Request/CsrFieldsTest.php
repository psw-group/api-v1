<?php

declare(strict_types=1);

namespace PswGroup\Test\Api\Unit\Model\Request;

use PHPUnit\Framework\TestCase;
use PswGroup\Api\Model\Request\CsrFields;

class CsrFieldsTest extends TestCase
{
    public function test_getters_and_setters(): void
    {
        $fields = $this->buildFields();

        $this->assertEquals('ssl-test.de', $fields->getCommonName());
        $this->assertEquals(['www.ssl-test.de', 'test-api.ssl-test.de'], $fields->getSans());
        $this->assertEquals('admin@ssl-test.de', $fields->getEmailAddress());
        $this->assertEquals('PSW GROUP GmbH & Co. KG', $fields->getOrganisationName());
        $this->assertEquals('IT', $fields->getOrganisationalUnitName());
        $this->assertEquals('Fulda', $fields->getLocalityName());
        $this->assertEquals('Hessen', $fields->getStateOrProvinceName());
        $this->assertEquals('DE', $fields->getCountryName());
    }

    public function test_is_serializable(): void
    {
        $fields = $this->buildFields();
        $serialized = json_encode($fields);

        $expected = '{"commonName":"ssl-test.de","countryName":"DE","stateOrProvinceName":"Hessen","localityName":"Fulda","organisationName":"PSW GROUP GmbH & Co. KG","organisationalUnitName":"IT","emailAddress":"admin@ssl-test.de","sans":["www.ssl-test.de","test-api.ssl-test.de"]}';

        $this->assertEquals($expected, $serialized);
    }

    public function provideLargeData(): array
    {
        return [
            'commonName' => ['setCommonName', str_repeat('X', 1025)],
            'countryName' => ['setCountryName', str_repeat('X', 256)],
            'stateOrProvinceName' => ['setStateOrProvinceName', str_repeat('X', 256)],
            'localityName' => ['setLocalityName', str_repeat('X', 256)],
            'organisationName' => ['setOrganisationName', str_repeat('X', 256)],
            'organisationalUnitName' => ['setOrganisationalUnitName', str_repeat('X', 256)],
            'emailAddress' => ['setEmailAddress', str_repeat('X', 256) . '@' . str_repeat('X', 256)],
        ];
    }

    /**
     * @dataProvider provideLargeData
     */
    public function test_validates_large_data(string $method, string $data): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $fields = $this->buildFields();
        $fields->{$method}($data);
    }

    public function provideValidCountries(): array
    {
        return [
            [null, null],
            ['', null],
            [' ', null],
            ['DE', 'DE'],
            ['de', 'DE'],
        ];
    }

    /**
     * @dataProvider provideValidCountries
     */
    public function test_sets_valid_country_name(?string $name, ?string $expected): void
    {
        $fields = $this->buildFields();
        $fields->setCountryName($name);

        $this->assertEquals($expected, $fields->getCountryName());
    }

    public function provideInvalidCountries(): array
    {
        return [
            ['D'],
            ['DEU'],
            ['Deutschland'],
            ['Germany'],
            ['D-'],
        ];
    }

    /**
     * @dataProvider provideInvalidCountries
     */
    public function test_validates_country_name(string $name): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $fields = $this->buildFields();
        $fields->setCountryName($name);
    }

    public function provideValidEmailAdresses(): array
    {
        return [
            [null, null],
            ['', null],
            [' ', null],
            ['foo@bar', 'foo@bar'],
            ['foo@bar.com', 'foo@bar.com'],
        ];
    }

    /**
     * @dataProvider provideValidEmailAdresses
     */
    public function test_sets_valid_email_address(?string $name, ?string $expected): void
    {
        $fields = $this->buildFields();
        $fields->setEmailAddress($name);

        $this->assertEquals($expected, $fields->getEmailAddress());
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
        $this->expectException(\InvalidArgumentException::class);

        $fields = $this->buildFields();
        $fields->setEmailAddress($name);
    }

    private function buildFields(): CsrFields
    {
        $fields = new CsrFields();
        $fields->setCommonName('ssl-test.de');
        $fields->setSans(['www.ssl-test.de', 'test-api.ssl-test.de']);
        $fields->setEmailAddress('admin@ssl-test.de');
        $fields->setOrganisationName('PSW GROUP GmbH & Co. KG');
        $fields->setOrganisationalUnitName('IT');
        $fields->setLocalityName('Fulda');
        $fields->setStateOrProvinceName('Hessen');
        $fields->setCountryName('DE');

        return $fields;
    }
}
