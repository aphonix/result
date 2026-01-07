<?php

/**
 * Global helper functions for Rust-style Result handling.
 * * These functions act as a prelude, allowing you to create Ok and Err
 * variants without the 'new' keyword, mimicking Rust's enum constructors.
 */

use Aphonix\Result\Ok;
use Aphonix\Result\Err;

if (!function_exists('Ok')) {
    /**
     * Creates a successful Result containing a value.
     *
     * @param mixed $value The success value.
     * @return Ok
     */
    function Ok($value)
    {
        return new Ok($value);
    }
}

if (!function_exists('Err')) {
    /**
     * Creates a failure Result containing an error cause.
     *
     * @param mixed $error The error cause/value.
     * @return Err
     */
    function Err($error)
    {
        return new Err($error);
    }
}