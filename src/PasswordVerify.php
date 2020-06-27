<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify;

use ExtKit\PasswordVerify\Combination;
use ExtKit\PasswordVerify\Exceptions\RuntimeException;

final class PasswordVerify
{
    /** @var string */
    private $password;

    /** @var Combination\CombinationCollection */
    private $collection;

    public function __construct(string $password)
    {
        $this->password = $password;
        $this->collection = new Combination\CombinationCollection();
    }

    public function setDefaultCombinations(): void
    {
        $this->deleteAllCombinations();
        $this->addCombination(new Combination\NotVerifyInitialLetterCombination(), true);
        $this->addCombination(new Combination\TryDeleteLastLetterCombination(), true);
    }

    public function addCombination(Combination\Combination $combination, bool $skipException = false): void
    {
        try {
            $combination->setPassword($this->password);
            $this->collection->add($combination);
        } catch (RuntimeException $exception) {
            if (!$skipException) {
                throw $exception;
            }
        }
    }

    public function deleteAllCombinations(): void
    {
        $this->collection->reset();
    }

    public function getAllowableValues(): array
    {
        return array_merge([$this->password], $this->collection->createAllowableValues());
    }

    public function verify(callable $verify): bool
    {
        foreach ($this->getAllowableValues() as $combination) {
            $result = $verify($combination);

            if (!is_bool($result)) {
                throw new \TypeError('Return value of callback must be of the type bool, ' . gettype($result) . ' returned');
            }

            if ($verify($combination) === true) {
                return true;
            }
        }

        return false;
    }
}
