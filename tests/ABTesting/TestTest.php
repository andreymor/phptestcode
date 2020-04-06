<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Tests\ABTesting;

use AMoretti\PhpTest\ABTesting\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class TestTest extends TestCase
{
    /**
     * @group abTest
     */
    public function testThatSameVariationIsAlwayesReturnedToSameSeed(): void
    {
        $variations = [
            1 => [
                'Design 01' => 50,
            ],
            2 => [
                'Design 02' => 20,
            ],
            3 => [
                'Design 03' => 15,
            ],
            4 => [
                'Design 04' => 15,
            ],
        ];

        $results = [];
        $attempts = 10000;

        for ($i = 0; $i < $attempts; ++$i) {
            $abTest = new Test($variations);
            $abTest->setSeed(123);
            $abTest->execute();
            $results[] = $abTest->getVariationName();
        }

        $this->assertCount(1, \array_unique($results));
    }

    /**
     * @group abTest
     * @dataProvider provideVariations
     */
    public function testGettingTheVariationProbabilityOfATest(array $variations): void
    {
        $attempts = 100000;
        $totalCountOfVariation = [];

        foreach ($variations as $id => $variation) {
            $totalCountOfVariation[$id] = 0;
        }

        for ($i = 0; $i < $attempts; ++$i) {
            $abTest = new Test($variations);
            $abTest->execute();
            ++$totalCountOfVariation[$abTest->getVariationId()];
        }

        foreach ($variations as $id => $variation) {
            ${"variation$id"} = $totalCountOfVariation[$id] / $attempts;
            $this->assertTrue(${"variation$id"} > (\array_values($variation)[0] - 1) / 100);
            $this->assertTrue(${"variation$id"} < (\array_values($variation)[0] + 1) / 100);
        }
    }

    /**
     * @group abTest
     */
    public function testThatVariationValuesAreNotProperPercentage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(Test::INVALID_TOTAL_VARIATION_RATE, 33));
        $abTest = new Test([['Invalid_Variation' => 33]]);
        $abTest->execute();
    }

    public function provideVariations(): \Generator
    {
        yield 'NOT_PRECISE_PERCENTUAL' => [
            [['Design 01' => 33], ['Design 02' => 41], ['Design 03' => 26]],
        ];

        yield 'RANDOM_ID' => [
            [55 => ['Design 01' => 21], ['Design 02' => 25], ['Design 03' => 54]],
        ];

        yield 'PRECISE_PERCENTUAL' => [
            [['Design 01' => 50], ['Design 02' => 25], ['Design 03' => 25]],
        ];

        yield 'BIG_NUMBER_OF_VARIATIONS' => [
            [['Design 01' => 15], ['Design 02' => 25], ['Design 03' => 25], ['Design 04' => 12], ['Design 05' => 23]],
        ];
    }
}
