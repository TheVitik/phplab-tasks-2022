<?php

namespace basics;

use InvalidArgumentException;

class BasicsValidator implements BasicsValidatorInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function isMinutesException(int $minute): void
    {
        if ($minute < 0 || $minute > 60) {
            throw new InvalidArgumentException('The minute variable contains a number from 0 to 59');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isYearException(int $year): void
    {
        if ($year < 1900) {
            throw new InvalidArgumentException('The year variable contains a year greater than or equal to 1900');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isValidStringException(string $input): void
    {
        if (strlen($input) != 6) {
            throw new InvalidArgumentException('The input variable contains a string of six digits');
        }
    }
}
