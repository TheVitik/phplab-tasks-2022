<?php

namespace basics;

use InvalidArgumentException;

class Basics implements BasicsInterface
{
    private const FIRST = 'first';
    private const SECOND = 'second';
    private const THIRD = 'third';
    private const FOURTH = 'fourth';

    public function __construct(private BasicsValidator $validator){}

    /**
     * @throws InvalidArgumentException
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);

        return match (true) {
            $minute > 45 || $minute == 0 => self::FOURTH,
            $minute > 30 => self::THIRD,
            $minute > 15 => self::SECOND,
            default => self::FIRST,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);

        return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);

        return (array_sum(str_split(substr($input, 0, 3))) === array_sum(str_split(substr($input, 3))));
    }
}
