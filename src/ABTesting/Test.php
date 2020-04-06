<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\ABTesting;

/**
 * Create a proper AB testing based on % variation
 */
class Test
{
    public const INVALID_TOTAL_VARIATION_RATE = 'The total count [%d] of variation values should be equal 100.';

    protected array $variations = [];

    protected int $variationId;

    protected string $variationName;

    protected array $variationValues = [];

    protected int $seed;

    public function __construct(array $variations)
    {
        $this->variations = $variations;
    }

    public function setSeed(?int $seedValue = null): void
    {
        $this->seed = $seedValue ?? \mt_rand();
    }

    public function getVariationId(): int
    {
        return $this->variationId;
    }

    public function getVariationName(): string
    {
        return $this->variationName;
    }

    public function execute(): void
    {
        if (isset($this->seed)) {
            \mt_srand($this->seed);
        }

        $totalOdds = 0;

        $this->validateVariations();

        $randomOddValue = \mt_rand(1, \array_sum($this->variationValues));

        foreach ($this->variations as $variation => $value) {
            $totalOdds += \array_values($value)[0];
            if ($randomOddValue <= $totalOdds) {
                $this->variationId = $variation;
                $this->variationName = \array_key_first($value);

                return;
            }
        }
    }

    protected function validateVariations(): void
    {
        $totalValues = 0;
        foreach ($this->variations as $variation) {
            $variationValue = \array_values($variation)[0];
            if (!\is_int($variationValue)) {
                throw new \InvalidArgumentException('Variation value should be an integer');
            }

            $totalValues += $variationValue;

            $this->variationValues[] = $variationValue;
        }

        if (0 !== $totalValues % 100) {
            throw new \InvalidArgumentException(\sprintf(self::INVALID_TOTAL_VARIATION_RATE, $totalValues));
        }
    }
}
