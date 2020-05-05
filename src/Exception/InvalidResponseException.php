<?php

declare(strict_types=1);

namespace PswGroup\Api\Exception;

use RuntimeException;
use Throwable;

/**
 * InvalidResponseException is raised when the server response is not valid.
 */
class InvalidResponseException extends RuntimeException
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
