<?php

declare(strict_types=1);

namespace PswGroup\Api\Exception;

use RuntimeException;
use Throwable;

/**
 * UnauthorizedException is raised when the current user doesn't have sufficient permissions to access data.
 */
class UnauthorizedException extends RuntimeException
{
    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
