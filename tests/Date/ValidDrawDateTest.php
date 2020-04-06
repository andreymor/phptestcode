<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Tests\Date;

use AMoretti\PhpTest\Date\ValidDrawDate;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ValidDrawDateTest extends TestCase
{
    protected $items;

    public function setUp(): void
    {
        $this->items = \range(1, 100);
        parent::setUp();
    }

    /**
     * @dataProvider provideDates
     * @group drawDate
     */
    public function testGetNextValidDrawDate($dateTime, string $expected): void
    {
        $drawDate = new ValidDrawDate();

        $nextDrawDate = $drawDate->getNextValidDrawDate($dateTime);

        $this->assertEquals($nextDrawDate->format('Y-m-d H:i:s'), $expected);
    }

    /**
     * @group drawDate
     * @dataProvider provideInvalidDates
     */
    public function testShouldThrowException($invalidDateTime): void
    {
        $drawDate = new ValidDrawDate();
        $this->expectException(\InvalidArgumentException::class);
        $drawDate->getNextValidDrawDate($invalidDateTime);
    }

    public function provideInvalidDates(): \Generator
    {
        yield 'NOT_A_STRING' => [123123];
        yield 'STRING_NOT_A_DATE' => ['222'];
    }

    public function provideDates(): \Generator
    {
        yield 'STRING_WED_BEFORE_20' => [
            '2020-04-01 19:00:00',
            '2020-04-01 20:00:00',
        ];

        yield 'DATE_WED_BEFORE_20' => [
            new \DateTimeImmutable('2020-04-01 19:00:00'),
            '2020-04-01 20:00:00',
        ];

        yield 'DATE_SAT_BEFORE_20' => [
            new \DateTimeImmutable('2020-04-04 19:00:00'),
            '2020-04-04 20:00:00',
        ];

        yield 'STRING_SAT_BEFORE_20' => [
            '2020-04-04 19:00:00',
            '2020-04-04 20:00:00',
        ];

        yield 'STRING_NEXT_SAT' => [
            '2020-04-02 19:00:00',
            '2020-04-04 20:00:00',
        ];

        yield 'DATE_NEXT_SAT' => [
            new \DateTimeImmutable('2020-04-02 19:00:00'),
            '2020-04-04 20:00:00',
        ];

        yield 'STRING_NEXT_WED_FROM_SAT' => [
            '2020-04-04 20:01:00',
            '2020-04-08 20:00:00',
        ];

        yield 'STRING_NEXT_WED_FROM_TUESDAY' => [
            '2020-04-07 20:01:00',
            '2020-04-08 20:00:00',
        ];

        yield 'STRING_NEXT_SAT_FROM_THURSDAY' => [
            '2020-04-08 20:01:00',
            '2020-04-11 20:00:00',
        ];
    }
}
