<?php

declare(strict_types=1);

namespace Tests\Scalar\FloatingPoints;

use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

final class Float64Test extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Float64(-1.7976931348623157E308);
        $this->assertEquals(-1.7976931348623157E308, $min->getValue());

        // Test maximum value
        $max = new Float64(1.7976931348623157E308);
        $this->assertEquals(1.7976931348623157E308, $max->getValue());

        // Test zero
        $zero = new Float64(0.0);
        $this->assertEquals(0.0, $zero->getValue());

        // Test small positive value
        $small = new Float64(2.2250738585072014E-308);
        $this->assertEquals(2.2250738585072014E-308, $small->getValue());

        // Test small negative value
        $smallNeg = new Float64(-2.2250738585072014E-308);
        $this->assertEquals(-2.2250738585072014E-308, $smallNeg->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Float64(1.7976931348623158E308 * 2); // MAX_VALUE * 2
    }

    public function testNegativeInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Float64(-1.7976931348623158E308 * 2); // MIN_VALUE * 2
    }

    public function testAddition(): void
    {
        $a = new Float64(1.5);
        $b = new Float64(2.5);
        $sum = $a->add($b);
        $this->assertEquals(4.0, $sum->getValue());
    }

    public function testSubtraction(): void
    {
        $a = new Float64(5.0);
        $b = new Float64(2.5);
        $diff = $a->subtract($b);
        $this->assertEquals(2.5, $diff->getValue());
    }

    public function testMultiplication(): void
    {
        $a = new Float64(2.5);
        $b = new Float64(2.0);
        $product = $a->multiply($b);
        $this->assertEquals(5.0, $product->getValue());
    }

    public function testDivision(): void
    {
        $a = new Float64(5.0);
        $b = new Float64(2.0);
        $quotient = $a->divide($b);
        $this->assertEquals(2.5, $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Float64(5.0);
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Float64(0.0));
    }

    public function testEquals(): void
    {
        $a = new Float64(1.5);
        $b = new Float64(1.5);
        $c = new Float64(2.5);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testIsGreaterThan(): void
    {
        $a = new Float64(2.5);
        $b = new Float64(1.5);
        $c = new Float64(2.5);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
    }

    public function testIsLessThan(): void
    {
        $a = new Float64(1.5);
        $b = new Float64(2.5);
        $c = new Float64(1.5);

        $this->assertTrue($a->isLessThan($b));
        $this->assertFalse($a->isLessThan($c));
    }

    public function testStringConversion(): void
    {
        $float = new Float64(1.5);
        $this->assertEquals('1.5', (string)$float);
    }

    public function testPrecision(): void
    {
        // Test that precision is maintained within Float64 limits
        $value = 1.2345678901234567;
        $float = new Float64($value);
        $this->assertEquals($value, $float->getValue(), '', 1E-15); // Allow for small floating-point differences
    }

    public function testSpecialValues(): void
    {
        // Test NaN
        $nan = new Float64(NAN);
        $this->assertTrue(is_nan($nan->getValue()));

        // INF and -INF are now disallowed, so expect OutOfRangeException
        $this->expectException(\OutOfRangeException::class);
        new Float64(INF);

        $this->expectException(\OutOfRangeException::class);
        new Float64(-INF);
    }
}
