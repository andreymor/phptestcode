<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Date;

\date_default_timezone_set('UTC');

class ValidDrawDate
{
    protected array $validDaysOfWeek = [
        'next Saturday 20 hours' => [3, 4, 5],
        'next Wednesday 20 hours' => [6, 7, 1, 2],
    ];

    public const DRAW_DATE_TIME_START = 20;

    public function getNextValidDrawDate($dateTime = null): \DateTimeImmutable
    {
        $dateTime = $this->getValidDate($dateTime);

        $currentDayOfTheWeek = (int) $dateTime->format('N');
        $currentTime = $dateTime->format('G');

        foreach ($this->validDaysOfWeek as $nextValidDate => $daysOfTheWeek) {
            if (\in_array($currentDayOfTheWeek, $daysOfTheWeek, true)) {
                if (3 === $currentDayOfTheWeek || 6 === $currentDayOfTheWeek) {
                    if ($currentTime < static::DRAW_DATE_TIME_START) {
                        return $dateTime->setTime(static::DRAW_DATE_TIME_START, 0);
                    }
                }
               return $dateTime->modify($nextValidDate);
            }
        }
    }

    protected function getValidDate($dateTime)
    {
        $dateTime = $dateTime ?? new \DateTimeImmutable();

        if (!\is_string($dateTime) && !$dateTime instanceof \DateTimeImmutable) {
            throw new \InvalidArgumentException('Date must be either a string or a DateTimeImmutable instance');
        }
        if (\is_string($dateTime) && !(bool) \strtotime($dateTime)) {
            throw new \InvalidArgumentException('Date must be a valid date format');
        }

        return $dateTime instanceof \DateTimeImmutable ? $dateTime : new \DateTimeImmutable($dateTime);
    }
}
