<?php
/**
 * Create the next tests in tests folder for next methods:
 * sayHello(), sayHelloArgument(), sayHelloArgumentWrapper(), countArguments(), countArgumentsWrapper().
 * Test should be placed in folder tests.
 * The name should start with capital letter and end with the word Test.
 * (Example: SayHelloTest.php)
 * See details below.
 *
 * Note: In Test don't forget to implement setUp() function for creating Function Class object and write it to the variable
 * to use this object in the test.
 * (For example: variable - $functions)
 *
 * Note: Don't forget to write PHPDoc's, Type hint's and DataProvider's for test.
 *
 * Note: For writing tests try to use PHPUnit Manual:
 * https://phpunit.readthedocs.io/en/9.5/index.html
 */

namespace functions;

use InvalidArgumentException;

class Functions
{
    public function sayHello(): string
    {
        return 'Hello';
    }

    public function sayHelloArgument(mixed $arg): string
    {
        return "Hello $arg";
    }

    /**
     * @throws InvalidArgumentException
     */
    public function sayHelloArgumentWrapper(mixed $arg): string
    {
        if (! is_numeric($arg) && ! is_string($arg) && ! is_bool($arg)) {
            throw new InvalidArgumentException('Invalid type of the argument');
        }

        return $this->sayHelloArgument($arg);
    }

    /**
     * @return array [
     *      'argument_count' => int,
     *      'argument_values' = array
     * ]
     */
    public function countArguments(): array
    {
        return [
            'argument_count' => func_num_args(),
            'argument_values' => func_get_args(),
        ];
    }

    /**
     * @return array [
     *      'argument_count' => int,
     *      'argument_values' = array
     * ]
     * @throws InvalidArgumentException
     */
    public function countArgumentsWrapper(): array
    {
        if (func_num_args() > 0) {
            foreach (func_get_args() as $argument) {
                if (! is_string($argument)) {
                    throw new InvalidArgumentException('String type of arguments required');
                }
            }
        }

        return $this->countArguments(...func_get_args());
    }
}
