<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Tests\Iterator;

use AMoretti\PhpTest\Iterator\RandomNumber;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class RandomNumberTest extends TestCase
{
    protected $items;

    public function setUp(): void
    {
        $this->items = \range(1, 500);
        parent::setUp();
    }

    /**
     * @group randomNumber
     */
    public function testRemovedFromEnd(): void
    {
        $randomNumber = new RandomNumber();
        $randomItems = $randomNumber->getItems();
        $lastItem = \end($randomItems);
        $randomNumber->removeAndDiscardRandomValueFromTheEnd();

        $this->assertCount(\count($this->items) - 1, $randomNumber->getItems());
        $this->assertEquals($randomNumber->getItemRemoved(), \array_values(\array_diff($this->items, $randomNumber->getItems()))[0]);
        $this->assertEquals($lastItem, \array_values(\array_diff($this->items, $randomNumber->getItems()))[0]);
    }

    /**
     * @group randomNumber
     */
    public function testRemoveFromBeginning(): void
    {
        $randomNumber = new RandomNumber();
        $randomItems = $randomNumber->getItems();
        \reset($randomItems);
        $firstItem = \current($randomItems);
        $randomNumber->removeAndDiscardRandomValueFromTheBeginning();

        $this->assertCount(\count($this->items) - 1, $randomNumber->getItems());
        $this->assertEquals($randomNumber->getItemRemoved(), \array_values(\array_diff($this->items, $randomNumber->getItems()))[0]);
        $this->assertEquals($firstItem, \array_values(\array_diff($this->items, $randomNumber->getItems()))[0]);
    }

    /**
     * @group randomNumber
     */
    public function testRemoveFromRandomPosition(): void
    {
        $randomNumber = new RandomNumber();
        $randomNumber->removeAndDiscardRandomValueFromRandomPosition();

        $this->assertCount(\count($this->items) - 1, $randomNumber->getItems());
        $this->assertEquals($randomNumber->getItemRemoved(), \array_values(\array_diff($this->items, $randomNumber->getItems()))[0]);
    }
}
