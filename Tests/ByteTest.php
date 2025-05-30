<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Scalar\Byte;
use PHPUnit\Framework\TestCase;

final class ByteTest extends TestCase
{
    /**
     * Test that the constructor throws an exception when the value is out of range.
     */
    public function testConstructorThrowsExceptionOnInvalidValue(): void
    {
        $this->expectException(\OutOfRangeException::class);
        new Byte(300);
    }

    /**
     * Test that the constructor correctly assigns the value.
     */
    public function testConstructorAssignsValidValue()
    {
        $byte = new Byte(100);
        $this->assertEquals(100, $byte->getValue());
    }

    /**
     * Test bitwise AND operation.
     */
    public function testAndOperation()
    {
        $byte1 = new Byte(170); // 10101010
        $byte2 = new Byte(85);  // 01010101
        $result = $byte1->and($byte2);

        $this->assertEquals(0, $result->getValue()); // 00000000
    }

    /**
     * Test bitwise OR operation.
     */
    public function testOrOperation()
    {
        $byte1 = new Byte(170); // 10101010
        $byte2 = new Byte(85);  // 01010101
        $result = $byte1->or($byte2);

        $this->assertEquals(255, $result->getValue()); // 11111111
    }

    /**
     * Test bitwise XOR operation.
     */
    public function testXorOperation()
    {
        $byte1 = new Byte(170); // 10101010
        $byte2 = new Byte(85);  // 01010101
        $result = $byte1->xor($byte2);

        $this->assertEquals(255, $result->getValue()); // 11111111
    }

    /**
     * Test bitwise NOT operation.
     */
    public function testNotOperation()
    {
        $byte = new Byte(170); // 10101010
        $result = $byte->not();

        $this->assertEquals(85, $result->getValue()); // 01010101
    }

    /**
     * Test left bit shifting.
     */
    public function testShiftLeftOperation()
    {
        $byte = new Byte(15); // 00001111
        $result = $byte->shiftLeft(2);

        $this->assertEquals(60, $result->getValue()); // 00111100
    }

    /**
     * Test right bit shifting.
     */
    public function testShiftRightOperation()
    {
        $byte = new Byte(240); // 11110000
        $result = $byte->shiftRight(2);

        $this->assertEquals(60, $result->getValue()); // 00111100
    }

    /**
     * Test equality comparison between two bytes.
     */
    public function testEquals()
    {
        $byte1 = new Byte(100);
        $byte2 = new Byte(100);

        $this->assertTrue($byte1->equals($byte2));
    }

    /**
     * Test greater than comparison.
     */
    public function testIsGreaterThan()
    {
        $byte1 = new Byte(200);
        $byte2 = new Byte(100);

        $this->assertTrue($byte1->isGreaterThan($byte2));
    }

    /**
     * Test less than comparison.
     */
    public function testIsLessThan()
    {
        $byte1 = new Byte(50);
        $byte2 = new Byte(100);

        $this->assertTrue($byte1->isLessThan($byte2));
    }

    /**
     * Test converting byte to binary string.
     */
    public function testToBinary()
    {
        $byte = new Byte(170); // 10101010
        $this->assertEquals('10101010', $byte->toBinary());
    }

    /**
     * Test converting byte to hexadecimal string.
     */
    public function testToHex()
    {
        $byte = new Byte(170); // 0xAA
        $this->assertEquals('AA', $byte->toHex());
    }

    /**
     * Test creating a byte from binary string.
     */
    public function testFromBinary()
    {
        $byte = Byte::fromBinary('10101010');
        $this->assertEquals(170, $byte->getValue());
    }

    /**
     * Test creating a byte from hexadecimal string.
     */
    public function testFromHex()
    {
        $byte = Byte::fromHex('AA');
        $this->assertEquals(170, $byte->getValue());
    }

    /**
     * Test adding a value to the byte and wrapping around at 255.
     */
    public function testAddWithOverflow()
    {
        $byte = new Byte(250);
        $result = $byte->add(10);

        $this->assertEquals(4, $result->getValue()); // 250 + 10 = 260, wrapped to 4
    }

    /**
     * Test subtracting a value from the byte and wrapping around at 0.
     */
    public function testSubtractWithUnderflow()
    {
        $byte = new Byte(5);
        $result = $byte->subtract(10);

        $this->assertEquals(251, $result->getValue()); // 5 - 10 = -5, wrapped to 251
    }

    /**
     * Test string representation of the byte.
     */
    public function testToString()
    {
        $byte = new Byte(100);
        $this->assertEquals('100', (string) $byte);
    }
}
