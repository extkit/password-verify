<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Combination;

interface Combination
{
    public function setPassword(string $password): void;

    public function __toString(): string;
}
