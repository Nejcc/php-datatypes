<?php

declare(strict_types=1);

namespace Tests\Scalar;

use Nejcc\PhpDatatypes\Scalar\Byte;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

final class ByteTest extends TestCase
{
    public function testValidRange(): void
    {
        // Test minimum value
        $min = new Byte(0);
        $this->assertEquals(0, $min->getValue());

        // Test maximum value
        $max = new Byte(255);
        $this->assertEquals(255, $max->getValue());

        // Test a value in the middle of the range
        $middle = new Byte(128);
        $this->assertEquals(128, $middle->getValue());
    }

    public function testInvalidRange(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Byte(256); // MAX_VALUE + 1
    }

    public function testNegativeValue(): void
    {
        $this->expectException(OutOfRangeException::class);
        new Byte(-1);
    }

    public function testAddition(): void
    {
        $a = new Byte(200);
        $b = new Byte(50);
        $sum = $a->add($b);
        $this->assertEquals(250, $sum->getValue());
    }

    public function testAdditionWithWrap(): void
    {
        $a = new Byte(200);
        $b = new Byte(100);
        $sum = $a->add($b);
        $this->assertEquals(44, $sum->getValue()); // (200 + 100) % 256 = 44
    }

    public function testSubtraction(): void
    {
        $a = new Byte(100);
        $b = new Byte(50);
        $diff = $a->subtract($b);
        $this->assertEquals(50, $diff->getValue());
    }

    public function testSubtractionWithWrap(): void
    {
        $a = new Byte(50);
        $b = new Byte(100);
        $diff = $a->subtract($b);
        $this->assertEquals(206, $diff->getValue()); // (50 - 100 + 256) % 256 = 206
    }

    public function testMultiplication(): void
    {
        $a = new Byte(10);
        $b = new Byte(20);
        $product = $a->multiply($b);
        $this->assertEquals(200, $product->getValue());
    }

    public function testMultiplicationWithWrap(): void
    {
        $a = new Byte(20);
        $b = new Byte(20);
        $product = $a->multiply($b);
        $this->assertEquals(144, $product->getValue()); // (20 * 20) % 256 = 144
    }

    public function testDivision(): void
    {
        $a = new Byte(100);
        $b = new Byte(2);
        $quotient = $a->divide($b);
        $this->assertEquals(50, $quotient->getValue());
    }

    public function testDivisionByZero(): void
    {
        $a = new Byte(100);
        $this->expectException(\DivisionByZeroError::class);
        $a->divide(new Byte(0));
    }

    public function testBitwiseOperations(): void
    {
        $a = new Byte(0b10101010);
        $b = new Byte(0b11110000);

        // AND
        $and = $a->and($b);
        $this->assertEquals(0b10100000, $and->getValue());

        // OR
        $or = $a->or($b);
        $this->assertEquals(0b11111010, $or->getValue());

        // XOR
        $xor = $a->xor($b);
        $this->assertEquals(0b01011010, $xor->getValue());

        // NOT
        $not = $a->not();
        $this->assertEquals(0b01010101, $not->getValue());
    }

    public function testShiftOperations(): void
    {
        $byte = new Byte(0b10101010);

        // Left shift
        $leftShift = $byte->leftShift(2);
        $this->assertEquals(0b10101000, $leftShift->getValue());

        // Right shift
        $rightShift = $byte->rightShift(2);
        $this->assertEquals(0b00101010, $rightShift->getValue());
    }

    public function testStringConversion(): void
    {
        $byte = new Byte(170); // 0b10101010
        $this->assertEquals('170', (string)$byte);
    }

    public function testBinaryConversion(): void
    {
        $byte = new Byte(170); // 0b10101010
        $this->assertEquals('10101010', $byte->toBinary());
    }

    public function testHexadecimalConversion(): void
    {
        $byte = new Byte(170); // 0xAA
        $this->assertEquals('AA', $byte->toHex());
    }

    public function testEquals(): void
    {
        $a = new Byte(100);
        $b = new Byte(100);
        $c = new Byte(200);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }
}
