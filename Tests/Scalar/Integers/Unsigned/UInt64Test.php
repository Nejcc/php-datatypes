<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt64;
use OutOfRangeException;
use OverflowException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class UInt64Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new UInt64('0');
        $this->assertEquals('0', $min->getValue());

        // Test maximum value
        $max = new UInt64('18446744073709551615');
        $this->assertEquals('18446744073709551615', $max->getValue());

        // Test a value in the middle of the range
        $middle = new UInt64('9223372036854775807');
        $this->assertEquals('9223372036854775807', $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new UInt64('18446744073709551616'); // MAX_VALUE + 1
    }

    public function testNegativeValue(): void
    {
        $this->expectException(OutOfRangeException::class);
        new UInt64('-1');
    }

    public function testAddition(): void
    {
        $a = new UInt64('18446744073709551610');
        $b = new UInt64('5');
        $sum = $a->add($b);
        $this->assertEquals('18446744073709551615', $sum->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new UInt64('18446744073709551615');
        $this->expectException(OverflowException::class);
        $max->add(new UInt64('1'));
    }

    public function testSubtraction(): void
    {
        $a = new UInt64('100');
        $b = new UInt64('50');
        $diff = $a->subtract($b);
        $this->assertEquals('50', $diff->getValue());
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new UInt64('0');
        $this->expectException(UnderflowException::class);
        $min->subtract(new UInt64('1'));
    }

    public function testMultiplication(): void
    {
        $a = new UInt64('9223372036854775807');
        $b = new UInt64('2');
        $product = $a->multiply($b);
        $this->assertEquals('18446744073709551614', $product->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new UInt64('18446744073709551615');
        $this->expectException(OverflowException::class);
        $max->multiply(new UInt64('2'));
    }

    public function testDivision(): void
    {
        $a = new UInt64('100');
        $b = new UInt64('2');
        $quotient = $a->divide($b);
        $this->assertEquals('50', $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new UInt64('100');
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new UInt64('0'));
    }

    public function testComparison(): void
    {
        $a = new UInt64('100');
        $b = new UInt64('50');
        $c = new UInt64('100');

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isLessThan($b));
        $this->assertTrue($a->equals($c));
        $this->assertFalse($a->equals($b));
    }

    public function testStringConversion(): void
    {
        $value = '18446744073709551615';
        $uint64 = new UInt64($value);
        $this->assertEquals($value, (string) $uint64);
    }

    public function testZeroOperations(): void
    {
        $zero = new UInt64('0');
        $one = new UInt64('1');

        // Addition with zero
        $sum = $zero->add($one);
        $this->assertEquals('1', $sum->getValue());

        // Multiplication with zero
        $product = $zero->multiply($one);
        $this->assertEquals('0', $product->getValue());

        // Division of zero
        $quotient = $zero->divide($one);
        $this->assertEquals('0', $quotient->getValue());
    }
}
