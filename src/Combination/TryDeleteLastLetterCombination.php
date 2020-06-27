<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Combination;

use ExtKit\PasswordVerify\Exceptions\ShortTextException;
use function mb_strlen;
use function mb_substr;

final class TryDeleteLastLetterCombination implements Combination
{
    /** @var string */
    private $password;

    /** @var int */
    private $minimumLength;

    public function __construct(int $minimumLength = 1)
    {
        $this->minimumLength = $minimumLength;
    }

    public function setPassword(string $password): void
    {
        if (mb_strlen($password) <= $this->minimumLength) {
            throw new ShortTextException($password, $this->minimumLength);
        }

        $this->password = $password;
    }

    public function __toString(): string
    {
        return mb_substr($this->password, 0, -1);
    }
}
