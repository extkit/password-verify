<?php declare(strict_types=1);

namespace ExtKit\PasswordVerify\Combination;

use Countable;
use Iterator;

final class CombinationCollection implements Countable, Iterator
{
    /** @var array<Combination> */
    private $values = [];

    /** @var int */
    private $position = 0;

    public function reset(): void
    {
        $this->values = [];
        $this->position = 0;
    }

    public function add(Combination $combination): void
    {
        $this->values[] = $combination;
    }

    /**
     * Creates values that can be accepted within the entered password
     *
     * @return array<string>
     */
    public function createAllowableValues(): array
    {
        return array_map(static function (Combination $combination) {
            return (string)$combination;
        }, $this->values);
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function current(): Combination
    {
        return $this->values[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->values[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
