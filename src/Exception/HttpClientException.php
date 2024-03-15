<?php

declare(strict_types=1);

namespace PswGroup\Api\Exception;

use Psr\Http\Message\RequestInterface;
use RuntimeException;
use Throwable;

/**
 * HttpClientException is raised when the HTTP client throws an exception.
 */
class HttpClientException extends RuntimeException
{
    private readonly RequestInterface $request;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $message, RequestInterface $request, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->request = $request;
    }

    public static function create(RequestInterface $request, ?Throwable $previous = null, ?string $message = null): self
    {
        if ($message === null) {
            $message = 'Exception thrown by the HTTP client while sending the request.';

            if ($previous !== null) {
                $message = sprintf(
                    'HTTP client exception: %s.',
                    $previous->getMessage()
                );
            }
        }

        return new self($message, $request, $previous);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
