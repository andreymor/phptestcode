<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Iterator;

/**
 * Creates an arbitrary array based on a specific range
 * Replaces all values that are ONLY
 * - multiple of 3 with Fizz
 * - multiple of 5 with Buzz
 * Replaces all values that are mutiple of 3 AND 5 with FizzBuzz.
 */
class FizzBuzz
{
    public const FIZZ = 'Fizz';
    public const BUZZ = 'Buzz';
    public const FIZZ_BUZZ = self::FIZZ.self::BUZZ;

    protected array $items = [];

    public function __construct(int $start = 1, int $end = 100)
    {
        $this->items = \range($start, $end);
    }

    /**
     * Recreates the current array of items to replace
     * multiples of 3 AND 5 as FizzBuzz
     * multiples of 3 ONLY with Fizz
     * and multiples of 5 ONLY with Buzz.
     */
    public function build(): array
    {
        foreach ($this->items as &$value) {
            if ($this->isFizzBuzz($value)) {
                $value = self::FIZZ_BUZZ;
                continue;
            }

            if ($this->isFizz($value)) {
                $value = self::FIZZ;
                continue;
            }

            if ($this->isBuzz($value)) {
                $value = self::BUZZ;
                continue;
            }
        }

        return $this->items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Checks if the current value is a multiple of 3 and 5.
     */
    protected function isFizzBuzz(int $value): bool
    {
        return 0 === $value % 3 && 0 === $value % 5;
    }

    /**
     * Checks if the current value is multiple of 3.
     */
    protected function isFizz(int $value): bool
    {
        return 0 === $value % 3;
    }

    /**
     * Checks if the current value is multiple of 5.
     */
    protected function isBuzz(int $value): bool
    {
        return 0 === $value % 5;
    }
}
