<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use OutOfRangeException;
use OverflowException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class Int8Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Int8(-128);
        $this->assertEquals(-128, $min->getValue());

        // Test maximum value
        $max = new Int8(127);
        $this->assertEquals(127, $max->getValue());

        // Test zero
        $zero = new Int8(0);
        $this->assertEquals(0, $zero->getValue());

        // Test a value in the middle of the range
        $middle = new Int8(64);
        $this->assertEquals(64, $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int8(128); // MAX_VALUE + 1
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int8(-129); // MIN_VALUE - 1
    }

    public function testAddition(): void
    {
        $a = new Int8(100);
        $b = new Int8(20);
        $sum = $a->add($b);
        $this->assertEquals(120, $sum->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new Int8(127);
        $this->expectException(OverflowException::class);
        $max->add(new Int8(1));
    }

    public function testAdditionUnderflow(): void
    {
        $min = new Int8(-128);
        $this->expectException(UnderflowException::class);
        $min->add(new Int8(-1));
    }

    public function testSubtraction(): void
    {
        $a = new Int8(100);
        $b = new Int8(20);
        $diff = $a->subtract($b);
        $this->assertEquals(80, $diff->getValue());
    }

    public function testSubtractionOverflow(): void
    {
        $max = new Int8(127);
        $this->expectException(OverflowException::class);
        $max->subtract(new Int8(-1));
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new Int8(-128);
        $this->expectException(UnderflowException::class);
        $min->subtract(new Int8(1));
    }

    public function testMultiplication(): void
    {
        $a = new Int8(10);
        $b = new Int8(5);
        $product = $a->multiply($b);
        $this->assertEquals(50, $product->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new Int8(127);
        $this->expectException(OverflowException::class);
        $max->multiply(new Int8(2));
    }

    public function testMultiplicationUnderflow(): void
    {
        $min = new Int8(-128);
        $this->expectException(UnderflowException::class);
        $min->multiply(new Int8(2));
    }

    public function testDivision(): void
    {
        $a = new Int8(100);
        $b = new Int8(2);
        $quotient = $a->divide($b);
        $this->assertEquals(50, $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Int8(100);
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Int8(0));
    }

    public function testDivisionNonIntegerResult(): void
    {
        $a = new Int8(5);
        $this->expectException(\UnexpectedValueException::class);
        $a->divide(new Int8(2));
    }

    public function testEquals(): void
    {
        $a = new Int8(100);
        $b = new Int8(100);
        $c = new Int8(50);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Int8(100);
        $b = new Int8(50);
        $c = new Int8(100);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
    }

    public function testIsLessThan(): void
    {
        $a = new Int8(50);
        $b = new Int8(100);
        $c = new Int8(50);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($a->isLessThan($c));
    }

    public function testStringConversion(): void
    {
        $int = new Int8(100);
        $this->assertEquals('100', (string)$int);
    }

    public function testZeroOperations(): void
    {
        $zero = new Int8(0);
        $one = new Int8(1);
        $negOne = new Int8(-1);

        // Addition with zero
        $sum = $zero->add($one);
        $this->assertEquals(1, $sum->getValue());

        // Subtraction with zero
        $diff = $zero->subtract($one);
        $this->assertEquals(-1, $diff->getValue());

        // Multiplication with zero
        $product = $zero->multiply($one);
        $this->assertEquals(0, $product->getValue());

        // Division of zero
        $quotient = $zero->divide($one);
        $this->assertEquals(0, $quotient->getValue());
    }
}
