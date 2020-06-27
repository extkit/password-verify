<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify;

final class PasswordVerify
{
    /** @var string */
    private $password;

    /** @var bool */
    private $notVerifyCaseInitialLetter = false;

    /** @var bool */
    private $tryDeleteLastLetter = false;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function notVerifyCaseInitialLetter(bool $value = true): void
    {
        $this->notVerifyCaseInitialLetter = $value;
    }

    public function tryDeleteLastLetter(bool $value = true): void
    {
        $this->tryDeleteLastLetter = $value;
    }

    public function verify(callable $verify): bool
    {
        foreach ($this->createCombinations() as $combination) {
            if ($verify($combination) === true) {
                return true;
            }
        }

        return false;
    }

    private function createCombinations(): array
    {
        $combinations = [$this->password];

        if ($this->notVerifyCaseInitialLetter && mb_strlen($this->password) > 1) {
            $firstLetter = mb_substr($this->password, 0, 1);
            $result = ctype_upper($firstLetter) ? lcfirst($this->password) : ucfirst($this->password);
            $combinations[] = $result;
        }

        if ($this->tryDeleteLastLetter && mb_strlen($this->password) > 1) {
            $combinations[] = mb_substr($this->password, 0, -1);
        }

        return $combinations;
    }
}
