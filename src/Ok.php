<?php

namespace Aphonix\Result;

/**
 * Ok variant of Result.
 *
 * Represents a successful result containing a value.
 *
 * @package Aphonix\Result
 */
class Ok extends Result
{
    /**
     * @var mixed The contained success value.
     */
    private $value;

    /**
     * Create a new Ok instance.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function is_ok(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function is_err(): bool
    {
        return false;
    }

    /**
     * Returns the contained value.
     *
     * @return mixed
     */
    public function unwrap()
    {
        return $this->value;
    }

    /**
     * Always throws an exception because this is an Ok variant.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function unwrap_err()
    {
        throw new \RuntimeException("called `Result::unwrap_err()` on an `Ok` value");
    }

    /**
     * Returns the contained value regardless of the message.
     *
     * @param string $msg
     * @return mixed
     */
    public function expect(string $msg)
    {
        return $this->value;
    }

    /**
     * Maps the Ok value to a new value using the provided closure.
     *
     * @param callable $op
     * @return Result
     */
    public function map(callable $op): Result
    {
        return \Ok($op($this->value));
    }

    /**
     * Does nothing and returns the current Ok instance.
     *
     * @param callable $op
     * @return Result
     */
    public function map_err(callable $op): Result
    {
        return $this;
    }

    /**
     * Chains a fallible operation: returns the Result of the closure.
     *
     * @param callable $op Must return a Result instance.
     * @return Result
     */
    public function and_then(callable $op): Result
    {
        return $op($this->value);
    }

    /**
     * Returns the current Ok instance, ignoring the provided Result.
     *
     * @param callable $op
     * @return Result
     */
    public function or_else(callable $op): Result
    {
        return $this;
    }
}