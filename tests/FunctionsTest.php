<?php

use PHPUnit\Framework\TestCase;
use functions\Functions;

class FunctionsTest extends TestCase
{
    protected Functions $functions;

    protected function setUp(): void
    {
        $this->functions = new Functions();
    }

    public function testSayHello()
    {
        $this->assertEquals('Hello', $this->functions->sayHello());
    }

    /**
     * @dataProvider sayHelloArgumentDataProvider
     */
    public function testSayHelloArgument($input, $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($input));
    }

    public function sayHelloArgumentDataProvider(): array
    {
        return [
            ['world', 'Hello world'],
            [true, 'Hello 1'],
            [777, 'Hello 777']
        ];
    }

    /**
     * @dataProvider sayHelloArgumentWrapperDataProvider
     */
    public function testNegativeSayHelloArgumentWrapper($input)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->sayHelloArgumentWrapper($input);
    }

    public function sayHelloArgumentWrapperDataProvider()
    {
        return [
            [[3.6, 5, 3]],
            [new stdClass()]
        ];
    }

    public function testPositiveSayHelloArgumentWrapper()
    {
        $this->assertEquals('Hello World', $this->functions->sayHelloArgumentWrapper('World'));
    }

    /**
     * @dataProvider countArgumentsDataProvider
     */
    public function testCountArguments($expected, ...$input)
    {
        $this->assertEquals($expected, $this->functions->countArguments(...$input));
    }

    public function countArgumentsDataProvider(): array
    {
        return [
            [
                [
                    'argument_count' => 0,
                    'argument_values' => [],
                ],
                ...[]
            ],
            [
                [
                    'argument_count' => 1,
                    'argument_values' => ['Hello'],
                ],
                'Hello'
            ],
            [
                [
                    'argument_count' => 3,
                    'argument_values' => ['Hello', 'world', '!'],
                ],
                ...['Hello', 'world', '!']
            ]
        ];
    }

    /**
     * @dataProvider countArgumentsWrapperDataProvider
     */
    public function testNegativeCountArgumentsWrapper($input)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->countArgumentsWrapper($input);
    }

    public function countArgumentsWrapperDataProvider()
    {
        return [
            [1],
            [...[3.6, 5, 3]],
            [...[true, false]],
            [new stdClass()]
        ];
    }

    public function testPositiveCountArgumentsWrapper()
    {
        $this->assertEquals(
            [
                'argument_count' => 1,
                'argument_values' => ['Hello'],
            ],
            $this->functions->countArguments('Hello')
        );
    }
}
