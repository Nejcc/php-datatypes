<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Unsigned;

use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt128;
use OutOfRangeException;
use OverflowException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class UInt128Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new UInt128('0');
        $this->assertEquals('0', $min->getValue());

        // Test maximum value
        $max = new UInt128('340282366920938463463374607431768211455');
        $this->assertEquals('340282366920938463463374607431768211455', $max->getValue());

        // Test a value in the middle of the range
        $middle = new UInt128('170141183460469231731687303715884105727');
        $this->assertEquals('170141183460469231731687303715884105727', $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new UInt128('340282366920938463463374607431768211456'); // MAX_VALUE + 1
    }

    public function testNegativeValue(): void
    {
        $this->expectException(OutOfRangeException::class);
        new UInt128('-1');
    }

    public function testAddition(): void
    {
        $a = new UInt128('340282366920938463463374607431768211450');
        $b = new UInt128('5');
        $sum = $a->add($b);
        $this->assertEquals('340282366920938463463374607431768211455', $sum->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new UInt128('340282366920938463463374607431768211455');
        $this->expectException(OverflowException::class);
        $max->add(new UInt128('1'));
    }

    public function testSubtraction(): void
    {
        $a = new UInt128('100');
        $b = new UInt128('50');
        $diff = $a->subtract($b);
        $this->assertEquals('50', $diff->getValue());
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new UInt128('0');
        $this->expectException(UnderflowException::class);
        $min->subtract(new UInt128('1'));
    }

    public function testMultiplication(): void
    {
        $a = new UInt128('170141183460469231731687303715884105727');
        $b = new UInt128('2');
        $product = $a->multiply($b);
        $this->assertEquals('340282366920938463463374607431768211454', $product->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new UInt128('340282366920938463463374607431768211455');
        $this->expectException(OverflowException::class);
        $max->multiply(new UInt128('2'));
    }

    public function testDivision(): void
    {
        $a = new UInt128('100');
        $b = new UInt128('2');
        $quotient = $a->divide($b);
        $this->assertEquals('50', $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new UInt128('100');
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new UInt128('0'));
    }

    public function testComparison(): void
    {
        $a = new UInt128('100');
        $b = new UInt128('50');
        $c = new UInt128('100');

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isLessThan($b));
        $this->assertTrue($a->equals($c));
        $this->assertFalse($a->equals($b));
    }

    public function testStringConversion(): void
    {
        $value = '340282366920938463463374607431768211455';
        $uint128 = new UInt128($value);
        $this->assertEquals($value, (string) $uint128);
    }

    public function testZeroOperations(): void
    {
        $zero = new UInt128('0');
        $one = new UInt128('1');

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
