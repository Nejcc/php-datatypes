<?php

declare(strict_types=1);

namespace Tests\Scalar\FloatingPoints;

use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

final class Float32Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Float32(-3.4028235E38);
        $this->assertEquals(-3.4028235E38, $min->getValue());

        // Test maximum value
        $max = new Float32(3.4028235E38);
        $this->assertEquals(3.4028235E38, $max->getValue());

        // Test zero
        $zero = new Float32(0.0);
        $this->assertEquals(0.0, $zero->getValue());

        // Test small positive value
        $small = new Float32(1.17549435E-38);
        $this->assertEquals(1.17549435E-38, $small->getValue());

        // Test small negative value
        $smallNeg = new Float32(-1.17549435E-38);
        $this->assertEquals(-1.17549435E-38, $smallNeg->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Float32(3.4028236E38); // MAX_VALUE + epsilon
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Float32(-3.4028236E38); // MIN_VALUE - epsilon
    }

    public function testAddition(): void
    {
        $a = new Float32(1.5);
        $b = new Float32(2.5);
        $sum = $a->add($b);
        $this->assertEquals(4.0, $sum->getValue());
    }

    public function testSubtraction(): void
    {
        $a = new Float32(5.0);
        $b = new Float32(2.5);
        $diff = $a->subtract($b);
        $this->assertEquals(2.5, $diff->getValue());
    }

    public function testMultiplication(): void
    {
        $a = new Float32(2.5);
        $b = new Float32(2.0);
        $product = $a->multiply($b);
        $this->assertEquals(5.0, $product->getValue());
    }

    public function testDivision(): void
    {
        $a = new Float32(5.0);
        $b = new Float32(2.0);
        $quotient = $a->divide($b);
        $this->assertEquals(2.5, $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Float32(5.0);
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Float32(0.0));
    }

    public function testEquals(): void
    {
        $a = new Float32(1.5);
        $b = new Float32(1.5);
        $c = new Float32(2.5);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Float32(2.5);
        $b = new Float32(1.5);
        $c = new Float32(2.5);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
    }

    public function testIsLessThan(): void
    {
        $a = new Float32(1.5);
        $b = new Float32(2.5);
        $c = new Float32(1.5);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($a->isLessThan($c));
    }

    public function testStringConversion(): void
    {
        $float = new Float32(1.5);
        $this->assertEquals('1.5', (string)$float);
    }

    public function testPrecision(): void
    {
        // Test that precision is maintained within Float32 limits
        $value = 1.23456789;
        $float = new Float32($value);
        $this->assertEquals($value, $float->getValue(), '', 1E-7); // Allow for small floating-point differences
    }

    public function testSpecialValues(): void
    {
        // Test NaN
        $nan = new Float32(NAN);
        $this->assertTrue(is_nan($nan->getValue()));

        // INF and -INF are now disallowed, so expect OutOfRangeException
        $this->expectException(\OutOfRangeException::class);
        new Float32(INF);

        $this->expectException(\OutOfRangeException::class);
        new Float32(-INF);
    }
}
