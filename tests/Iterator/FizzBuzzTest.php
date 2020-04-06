<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Tests\Iterator;

use AMoretti\PhpTest\Iterator\FizzBuzz;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FizzBuzzTest extends TestCase
{
    /**
     * @group fizzBuzz
     */
    public function testRemovedFromEnd(): void
    {
        $fizzBuzz = new FizzBuzz();
        $fizzBuzz->build();

        $this->assertEquals($fizzBuzz->getItems()[4], FizzBuzz::BUZZ);
        $this->assertEquals($fizzBuzz->getItems()[8], FizzBuzz::FIZZ);
        $this->assertEquals($fizzBuzz->getItems()[14], FizzBuzz::FIZZ_BUZZ);
    }
}
