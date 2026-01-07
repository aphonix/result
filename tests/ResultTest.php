<?php

namespace Aphonix\Result\Tests;

use PHPUnit\Framework\TestCase;
use Aphonix\Result\Result;
use Aphonix\Result\Ok;
use Aphonix\Result\Err;

/**
 * Unit tests for Rust-style Result implementation.
 */
class ResultTest extends TestCase
{
    /**
     * Test Ok variant creation and basic checks.
     */
    public function testOkVariant()
    {
        $res = Ok(42);

        $this->assertTrue($res->is_ok());
        $this->assertFalse($res->is_err());
        $this->assertEquals(42, $res->unwrap());
    }

    /**
     * Test Err variant creation and basic checks.
     */
    public function testErrVariant()
    {
        $res = Err("error message");

        $this->assertFalse($res->is_ok());
        $this->assertTrue($res->is_err());
        $this->assertEquals("error message", $res->unwrap_err());
    }

    /**
     * Test the map functionality.
     */
    public function testMap()
    {
        // Map on Ok
        $res = Ok(10)->map(function ($x) {
            return $x * 2;
        });
        $this->assertEquals(20, $res->unwrap());

        // Map on Err (should short-circuit)
        $res = Err("fail")->map(function ($x) {
            return $x * 2;
        });
        $this->assertTrue($res->is_err());
        $this->assertEquals("fail", $res->unwrap_err());
    }

    /**
     * Test and_then (monadic binding).
     */
    public function testAndThen()
    {
        $op = function ($x) {
            return Ok($x + 1);
        };

        $res = Ok(1)->and_then($op);
        $this->assertEquals(2, $res->unwrap());

        $errRes = Err("start fail")->and_then($op);
        $this->assertTrue($errRes->is_err());
    }

    /**
     * Test unwrap_or and unwrap_or_else.
     */
    public function testUnwrapDefault()
    {
        $this->assertEquals(10, Ok(10)->unwrap_or(20));
        $this->assertEquals(20, Err("fail")->unwrap_or(20));

        $this->assertEquals(20, Err("fail")->unwrap_or_else(function ($e) {
            return 20;
        }));
    }

    /**
     * Test expect method throwing exception on Err.
     */
    public function testExpectThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Custom panic message");

        Err("actual error")->expect("Custom panic message");
    }

    /**
     * Test unwrap throwing exception on Err.
     */
    public function testUnwrapThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("called `Result::unwrap()` on an `Err` value");

        Err("failure")->unwrap();
    }

    /**
     * Test or_else for error recovery.
     */
    public function testOrElse()
    {
        $res = Err("first")->or_else(function ($e) {
            return Ok("recovered");
        });

        $this->assertTrue($res->is_ok());
        $this->assertEquals("recovered", $res->unwrap());
    }
}