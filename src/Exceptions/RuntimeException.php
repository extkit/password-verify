<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Exceptions;

use Throwable;

abstract class RuntimeException extends \RuntimeException
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
