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

    public function testSayHello(){
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

    public function testSayHelloArgumentWrapper(){
        $this->expectException(InvalidArgumentException::class);
        $this->functions->sayHelloArgumentWrapper([1, 2, 3, 4, 5]);
    }

    public function testCountArguments(){
        // No arguments
        $this->assertEquals([
            'argument_count' => 0,
            'argument_values' => [],
        ],
            $this->functions->countArguments());

        // One string argument
        $this->assertEquals([
            'argument_count' => 1,
            'argument_values' => ['Hello'],
        ],
            $this->functions->countArguments('Hello'));

        // A couple of string arguments
        $this->assertEquals([
            'argument_count' => 3,
            'argument_values' => ['Hello', 'world', '!'],
        ],
            $this->functions->countArguments('Hello', 'world', '!'));
    }

    public function testCountArgumentsWrapper(){
        $this->expectException(InvalidArgumentException::class);
        $this->functions->countArgumentsWrapper(...[1, 3.6, true]);
    }
}