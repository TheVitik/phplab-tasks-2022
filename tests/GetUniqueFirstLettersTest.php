<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }

    public function positiveDataProvider(): array
    {
        return [
            [
                [
                    [
                        "name" => "Yellowstone Regional Airport",
                        "code" => "COD",
                        "city" => "Cody",
                        "state" => "Wyoming",
                        "address" => "2101 Roger Sedam Drive, Cody, WY 82414, USA",
                        "timezone" => "America/Denver",
                    ],
                    [
                        "name" => "Jackson Hole Airport",
                        "code" => "JAC",
                        "city" => "Jackson",
                        "state" => "Wyoming",
                        "address" => "1250 E Airport Rd, Jackson, WY 83001, USA",
                        "timezone" => "America/Denver",
                    ],
                    [
                        "name" => "Laramie Regional Airport",
                        "code" => "LAR",
                        "city" => "Laramie",
                        "state" => "Wyoming",
                        "address" => "555 N General Brees Rd, Laramie, WY 82070, USA",
                        "timezone" => "America/Denver",
                    ],
                    [
                        "name" => "Albuquerque Sunport International Airport",
                        "code" => "ABQ",
                        "city" => "Albuquerque",
                        "state" => "New Mexico",
                        "address" => "2200 Sunport Blvd, Albuquerque, NM 87106, USA",
                        "timezone" => "America/Los_Angeles",
                    ]
                ],
                ['A', 'J', 'L', 'Y']
            ]
        ];
    }
}
