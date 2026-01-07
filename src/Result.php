<?php

namespace Aphonix\Result;

use RuntimeException;

/**
 * Result is a type used for returning and propagating errors.
 *
 * Result<T, E> is the type used for returning and propagating errors.
 * It is an abstract class with two variants: Ok(T), representing success
 * and containing a value, and Err(E), representing error and containing an error cause.
 *
 * @package Aphonix\Result
 * @link https://github.com/aphonix/result
 */
abstract class Result
{
    /**
     * Returns true if the result is Ok.
     *
     * @return bool
     */
    abstract public function is_ok(): bool;

    /**
     * Returns true if the result is Err.
     *
     * @return bool
     */
    abstract public function is_err(): bool;

    /**
     * Returns the contained Ok value.
     *
     * @return mixed
     * @throws RuntimeException if the value is an Err, with a panic message.
     */
    abstract public function unwrap();

    /**
     * Returns the contained Err value.
     *
     * @return mixed
     * @throws RuntimeException if the value is an Ok, with a panic message.
     */
    abstract public function unwrap_err();

    /**
     * Returns the contained Ok value.
     *
     * @param string $msg The message to include in the exception if the result is Err.
     * @return mixed
     * @throws RuntimeException with the provided message if the result is Err.
     */
    abstract public function expect(string $msg);

    /**
     * Returns the contained Ok value or a provided default.
     *
     * @param mixed $default
     * @return mixed
     */
    public function unwrap_or($default)
    {
        return $this->is_ok() ? $this->unwrap() : $default;
    }

    /**
     * Maps a Result<T, E> to Result<U, E> by applying a function to a
     * contained Ok value, leaving an Err value untouched.
     *
     * @param callable $op Function to apply to the Ok value.
     * @return Result
     */
    abstract public function map(callable $op): Result;

    /**
     * Maps a Result<T, E> to Result<T, F> by applying a function to a
     * contained Err value, leaving an Ok value untouched.
     *
     * @param callable $op Function to apply to the Err value.
     * @return Result
     */
    abstract public function map_err(callable $op): Result;

    /**
     * Calls $op if the result is Ok, otherwise returns the Err value of self.
     * This function is often used for chaining fallible operations.
     *
     * @param callable $op Function that returns a Result object.
     * @return Result
     */
    abstract public function and_then(callable $op): Result;

    /**
     * Calls $op if the result is Err, otherwise returns the Ok value of self.
     *
     * @param callable $op Function that returns a Result object.
     * @return Result
     */
    abstract public function or_else(callable $op): Result;

    /**
     * Returns the contained Ok value or computes it from a closure.
     *
     * @param callable $op Closure that takes Err value and returns a default value.
     * @return mixed
     */
    public function unwrap_or_else(callable $op)
    {
        return $this->is_ok() ? $this->unwrap() : $op($this->unwrap_err());
    }
}