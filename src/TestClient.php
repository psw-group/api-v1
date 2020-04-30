<?php

declare(strict_types=1);

namespace PswGroup\Api;

/**
 * Client for the test environment.
 */
class TestClient extends GenericClient
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct('https://test-api.psw-group.de/v1', $clientId, $clientSecret);
    }
}
