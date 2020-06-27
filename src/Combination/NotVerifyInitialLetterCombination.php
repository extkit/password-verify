<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Combination;

use ExtKit\PasswordVerify\Exceptions\ShortTextException;

final class NotVerifyInitialLetterCombination implements Combination
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
        $firstLetter = mb_substr($this->password, 0, 1);

        return ctype_upper($firstLetter) ?
            lcfirst($this->password) :
            ucfirst($this->password);
    }
}
