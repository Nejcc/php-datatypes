<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Scalar\Char;
use PHPUnit\Framework\TestCase;

class CharTest extends TestCase
{
    /**
     * Test that the constructor throws an exception for a string longer than 1 character.
     */
    public function testConstructorThrowsExceptionOnInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Char('AB'); // Invalid, more than 1 character
    }

    /**
     * Test that the constructor correctly assigns a single character.
     */
    public function testConstructorAssignsValidValue()
    {
        $char = new Char('A');
        $this->assertEquals('A', $char->getValue());
    }

    /**
     * Test converting a character to uppercase.
     */
    public function testToUpperCase()
    {
        $char = new Char('a');
        $upperChar = $char->toUpperCase();

        $this->assertEquals('A', $upperChar->getValue());
    }

    /**
     * Test converting a character to lowercase.
     */
    public function testToLowerCase()
    {
        $char = new Char('A');
        $lowerChar = $char->toLowerCase();

        $this->assertEquals('a', $lowerChar->getValue());
    }

    /**
     * Test if a character is a letter.
     */
    public function testIsLetter()
    {
        $char = new Char('A');
        $this->assertTrue($char->isLetter());

        $char = new Char('1');
        $this->assertFalse($char->isLetter());
    }

    /**
     * Test if a character is a digit.
     */
    public function testIsDigit()
    {
        $char = new Char('1');
        $this->assertTrue($char->isDigit());

        $char = new Char('A');
        $this->assertFalse($char->isDigit());
    }

    /**
     * Test if a character is uppercase.
     */
    public function testIsUpperCase()
    {
        $char = new Char('A');
        $this->assertTrue($char->isUpperCase());

        $char = new Char('a');
        $this->assertFalse($char->isUpperCase());
    }

    /**
     * Test if a character is lowercase.
     */
    public function testIsLowerCase()
    {
        $char = new Char('a');
        $this->assertTrue($char->isLowerCase());

        $char = new Char('A');
        $this->assertFalse($char->isLowerCase());
    }

    /**
     * Test the equality of two Char objects.
     */
    public function testEquals()
    {
        $char1 = new Char('A');
        $char2 = new Char('A');
        $char3 = new Char('B');

        $this->assertTrue($char1->equals($char2));
        $this->assertFalse($char1->equals($char3));
    }

    /**
     * Test converting a character to its ASCII code.
     */
    public function testToAscii()
    {
        $char = new Char('A');
        $this->assertEquals(65, $char->toAscii());
    }

    /**
     * Test creating a Char from an ASCII code.
     */
    public function testFromAscii()
    {
        $char = Char::fromAscii(65); // ASCII for 'A'
        $this->assertEquals('A', $char->getValue());
    }

    /**
     * Test that an exception is thrown for an invalid ASCII code.
     */
    public function testFromAsciiThrowsExceptionOnInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        Char::fromAscii(300); // Invalid, out of ASCII range
    }

    /**
     * Test converting a Char object to a string.
     */
    public function testToString()
    {
        $char = new Char('A');
        $this->assertEquals('A', (string) $char);
    }
}
