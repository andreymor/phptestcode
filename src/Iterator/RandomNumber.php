<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Iterator;

/**
 * Class responsible for receiving arbitrary range values to create an array and remove a random element from it
 * There are three options done for this usecase.
 * I would choose either removing from the end OR from the beginning.
 * It is faster and since we do not depend on position, does not matter from where we remove it.
 */
class RandomNumber
{
    protected array $items = [];

    protected int $valueOfItemRemoved;

    /**
     * Creates a new array based on the input values
     * Shuffle the array to mix numbers.
     */
    public function __construct(int $start = 1, int $end = 500)
    {
        $this->items = \range($start, $end);
        \shuffle($this->items);
    }

    /**
     * Removes a random number from the end of the array
     * This option is fast but will push the removal for a unique position.
     */
    public function removeAndDiscardRandomValueFromTheEnd(): void
    {
        $this->valueOfItemRemoved = \array_pop($this->items);
    }

    /**
     * Removes a random number from the beginning of the array
     * This option is fast but will push the removal for a unique position.
     */
    public function removeAndDiscardRandomValueFromTheBeginning(): void
    {
        $this->valueOfItemRemoved = \array_shift($this->items);
    }

    /**
     * Removes a random number from a random position
     * This option is slower but will push the removal for a random position.
     */
    public function removeAndDiscardRandomValueFromRandomPosition(): void
    {
        $randomizedItem = \mt_rand(0, \count($this->items) - 1);
        $this->valueOfItemRemoved = $this->items[$randomizedItem];
        unset($this->items[$randomizedItem]);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItemRemoved(): int
    {
        return $this->valueOfItemRemoved;
    }
}
