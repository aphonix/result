<?php

namespace Aphonix\Result;

/**
 * Err variant of Result.
 *
 * Represents a failure result containing an error cause.
 *
 * @package Aphonix\Result
 */
class Err extends Result
{
    /**
     * @var mixed The contained error value.
     */
    private $error;

    /**
     * Create a new Err instance.
     *
     * @param mixed $error
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * {@inheritdoc}
     */
    public function is_ok(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function is_err(): bool
    {
        return true;
    }

    /**
     * Always throws an exception because this is an Err variant.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function unwrap()
    {
        $message = is_scalar($this->error) ? (string)$this->error : gettype($this->error);
        throw new \RuntimeException("called `Result::unwrap()` on an `Err` value: " . $message);
    }

    /**
     * Returns the contained error value.
     *
     * @return mixed
     */
    public function unwrap_err()
    {
        return $this->error;
    }

    /**
     * Always throws an exception with the provided custom message.
     *
     * @param string $msg
     * @return void
     * @throws \RuntimeException
     */
    public function expect(string $msg)
    {
        throw new \RuntimeException($msg . ": " . print_r($this->error, true));
    }

    /**
     * Does nothing and returns the current Err instance.
     *
     * @param callable $op
     * @return Result
     */
    public function map(callable $op): Result
    {
        return $this;
    }

    /**
     * Maps the Err value to a new error using the provided closure.
     *
     * @param callable $op
     * @return Result
     */
    public function map_err(callable $op): Result
    {
        return \Err($op($this->error));
    }

    /**
     * Does nothing and returns the current Err instance.
     *
     * @param callable $op
     * @return Result
     */
    public function and_then(callable $op): Result
    {
        return $this;
    }

    /**
     * Calls $op with the error and returns its Result.
     *
     * @param callable $op Must return a Result instance.
     * @return Result
     */
    public function or_else(callable $op): Result
    {
        return $op($this->error);
    }
}