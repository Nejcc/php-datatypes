<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use OutOfRangeException;
use OverflowException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class Int32Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Int32(-2147483648);
        $this->assertEquals(-2147483648, $min->getValue());

        // Test maximum value
        $max = new Int32(2147483647);
        $this->assertEquals(2147483647, $max->getValue());

        // Test zero
        $zero = new Int32(0);
        $this->assertEquals(0, $zero->getValue());

        // Test a value in the middle of the range
        $middle = new Int32(1073741824);
        $this->assertEquals(1073741824, $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int32(2147483648); // MAX_VALUE + 1
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int32(-2147483649); // MIN_VALUE - 1
    }

    public function testAddition(): void
    {
        $a = new Int32(1000000000);
        $b = new Int32(200000000);
        $sum = $a->add($b);
        $this->assertEquals(1200000000, $sum->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new Int32(2147483647);
        $this->expectException(OverflowException::class);
        $max->add(new Int32(1));
    }

    public function testAdditionUnderflow(): void
    {
        $min = new Int32(-2147483648);
        $this->expectException(UnderflowException::class);
        $min->add(new Int32(-1));
    }

    public function testSubtraction(): void
    {
        $a = new Int32(1000000000);
        $b = new Int32(200000000);
        $diff = $a->subtract($b);
        $this->assertEquals(800000000, $diff->getValue());
    }

    public function testSubtractionOverflow(): void
    {
        $max = new Int32(2147483647);
        $this->expectException(OverflowException::class);
        $max->subtract(new Int32(-1));
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new Int32(-2147483648);
        $this->expectException(UnderflowException::class);
        $min->subtract(new Int32(1));
    }

    public function testMultiplication(): void
    {
        $a = new Int32(100000);
        $b = new Int32(20000);
        $product = $a->multiply($b);
        $this->assertEquals(2000000000, $product->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new Int32(2147483647);
        $this->expectException(OverflowException::class);
        $max->multiply(new Int32(2));
    }

    public function testMultiplicationUnderflow(): void
    {
        $min = new Int32(-2147483648);
        $this->expectException(UnderflowException::class);
        $min->multiply(new Int32(2));
    }

    public function testDivision(): void
    {
        $a = new Int32(1000000000);
        $b = new Int32(2);
        $quotient = $a->divide($b);
        $this->assertEquals(500000000, $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Int32(1000000000);
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Int32(0));
    }

    public function testDivisionNonIntegerResult(): void
    {
        $a = new Int32(5);
        $this->expectException(\UnexpectedValueException::class);
        $a->divide(new Int32(2));
    }

    public function testEquals(): void
    {
        $a = new Int32(1000000000);
        $b = new Int32(1000000000);
        $c = new Int32(500000000);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Int32(1000000000);
        $b = new Int32(500000000);
        $c = new Int32(1000000000);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
    }

    public function testIsLessThan(): void
    {
        $a = new Int32(500000000);
        $b = new Int32(1000000000);
        $c = new Int32(500000000);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($a->isLessThan($c));
    }

    public function testStringConversion(): void
    {
        $int = new Int32(1000000000);
        $this->assertEquals('1000000000', (string)$int);
    }

    public function testZeroOperations(): void
    {
        $zero = new Int32(0);
        $one = new Int32(1);
        $negOne = new Int32(-1);

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
