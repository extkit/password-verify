<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Exceptions;

final class ShortTextException extends RuntimeException
{
    public function __construct(string $text, int $minimumLength)
    {
        $length = mb_strlen($text);
        $message = 'The text is very short. It must have at least ' . $length . ' characters.
        It currently has ' . $minimumLength . ' characters.';

        parent::__construct($message);
    }
}
