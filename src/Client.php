<?php

namespace PswGroup\Api;

use BinSoul\Net\Hal\Client\HalResource;

/**
 * Executes requests and returns resources.
 */
interface Client
{
    /**
     * Executes a GET request with the given query parameters.
     *
     * @param mixed[] $query
     */
    public function get(string $uri, array $query = []): HalResource;

    /**
     * Executes a POST request with the given data.
     *
     * @param mixed[] $data
     */
    public function post(string $uri, array $data = []): HalResource;

    /**
     * Executes a PUT request with the given data.
     *
     * @param mixed[] $data
     */
    public function put(string $uri, array $data = []): HalResource;

    /**
     * Executes a DELETE request.
     */
    public function delete(string $uri): HalResource;
}
