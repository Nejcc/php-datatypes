<?php

declare(strict_types=1);

namespace Tests\Scalar\Integers\Signed;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int64;
use OutOfRangeException;
use OverflowException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class Int64Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Int64('-9223372036854775808');
        $this->assertEquals('-9223372036854775808', $min->getValue());

        // Test maximum value
        $max = new Int64('9223372036854775807');
        $this->assertEquals('9223372036854775807', $max->getValue());

        // Test zero
        $zero = new Int64('0');
        $this->assertEquals('0', $zero->getValue());

        // Test a value in the middle of the range
        $middle = new Int64('4611686018427387904');
        $this->assertEquals('4611686018427387904', $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int64('9223372036854775808'); // MAX_VALUE + 1
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Int64('-9223372036854775809'); // MIN_VALUE - 1
    }

    public function testAddition(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('200000000000000000');
        $sum = $a->add($b);
        $this->assertEquals('1200000000000000000', $sum->getValue());
    }

    public function testAdditionOverflow(): void
    {
        $max = new Int64('9223372036854775807');
        $this->expectException(OverflowException::class);
        $max->add(new Int64('1'));
    }

    public function testAdditionUnderflow(): void
    {
        $min = new Int64('-9223372036854775808');
        $this->expectException(UnderflowException::class);
        $min->add(new Int64('-1'));
    }

    public function testSubtraction(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('200000000000000000');
        $diff = $a->subtract($b);
        $this->assertEquals('800000000000000000', $diff->getValue());
    }

    public function testSubtractionOverflow(): void
    {
        $max = new Int64('9223372036854775807');
        $this->expectException(OverflowException::class);
        $max->subtract(new Int64('-1'));
    }

    public function testSubtractionUnderflow(): void
    {
        $min = new Int64('-9223372036854775808');
        $this->expectException(UnderflowException::class);
        $min->subtract(new Int64('1'));
    }

    public function testMultiplication(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('2');
        $product = $a->multiply($b);
        $this->assertEquals('2000000000000000000', $product->getValue());
    }

    public function testMultiplicationOverflow(): void
    {
        $max = new Int64('9223372036854775807');
        $this->expectException(OverflowException::class);
        $max->multiply(new Int64('2'));
    }

    public function testMultiplicationUnderflow(): void
    {
        $min = new Int64('-9223372036854775808');
        $this->expectException(UnderflowException::class);
        $min->multiply(new Int64('2'));
    }

    public function testDivision(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('2');
        $quotient = $a->divide($b);
        $this->assertEquals('500000000000000000', $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Int64('1000000000000000000');
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Int64('0'));
    }

    public function testDivisionNonIntegerResult(): void
    {
        $a = new Int64('5');
        $this->expectException(\UnexpectedValueException::class);
        $a->divide(new Int64('2'));
    }

    public function testEquals(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('1000000000000000000');
        $c = new Int64('500000000000000000');

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Int64('1000000000000000000');
        $b = new Int64('500000000000000000');
        $c = new Int64('1000000000000000000');

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
    }

    public function testIsLessThan(): void
    {
        $a = new Int64('500000000000000000');
        $b = new Int64('1000000000000000000');
        $c = new Int64('500000000000000000');

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($a->isLessThan($c));
    }

    public function testStringConversion(): void
    {
        $int = new Int64('1000000000000000000');
        $this->assertEquals('1000000000000000000', (string)$int);
    }

    public function testZeroOperations(): void
    {
        $zero = new Int64('0');
        $one = new Int64('1');
        $negOne = new Int64('-1');

        // Addition with zero
        $sum = $zero->add($one);
        $this->assertEquals('1', $sum->getValue());

        // Subtraction with zero
        $diff = $zero->subtract($one);
        $this->assertEquals('-1', $diff->getValue());

        // Multiplication with zero
        $product = $zero->multiply($one);
        $this->assertEquals('0', $product->getValue());

        // Division of zero
        $quotient = $zero->divide($one);
        $this->assertEquals('0', $quotient->getValue());
    }
}
