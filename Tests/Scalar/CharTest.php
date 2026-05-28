<?php

declare(strict_types=1);

namespace Tests\Scalar;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Scalar\Char;
use PHPUnit\Framework\TestCase;

final class CharTest extends TestCase
{
    public function testValidCharacters(): void
    {
        // Test ASCII characters
        $charA = new Char('A');
        $this->assertEquals('A', $charA->getValue());

        $charZ = new Char('Z');
        $this->assertEquals('Z', $charZ->getValue());

        // Test lowercase letters
        $charA = new Char('a');
        $this->assertEquals('a', $charA->getValue());

        // Test numbers
        $char0 = new Char('0');
        $this->assertEquals('0', $char0->getValue());

        // Test special characters
        $charSpace = new Char(' ');
        $this->assertEquals(' ', $charSpace->getValue());

        $charDot = new Char('.');
        $this->assertEquals('.', $charDot->getValue());
    }

    public function testInvalidCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Char('AB'); // More than one character
    }

    public function testEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Char(''); // Empty string
    }

    public function testStringConversion(): void
    {
        $char = new Char('X');
        $this->assertEquals('X', (string)$char);
    }

    public function testEquals(): void
    {
        $charA = new Char('A');
        $charB = new Char('B');
        $anotherCharA = new Char('A');

        $this->assertTrue($charA->equals($anotherCharA));
        $this->assertFalse($charA->equals($charB));
    }

    public function testIsLetter(): void
    {
        $charA = new Char('A');
        $charZ = new Char('Z');
        $char0 = new Char('0');
        $charSpace = new Char(' ');

        $this->assertTrue($charA->isLetter());
        $this->assertTrue($charZ->isLetter());
        $this->assertFalse($char0->isLetter());
        $this->assertFalse($charSpace->isLetter());
    }

    public function testIsDigit(): void
    {
        $char0 = new Char('0');
        $char9 = new Char('9');
        $charA = new Char('A');
        $charSpace = new Char(' ');

        $this->assertTrue($char0->isDigit());
        $this->assertTrue($char9->isDigit());
        $this->assertFalse($charA->isDigit());
        $this->assertFalse($charSpace->isDigit());
    }

    public function testIsWhitespace(): void
    {
        $charSpace = new Char(' ');
        $charTab = new Char("\t");
        $charNewline = new Char("\n");
        $charA = new Char('A');

        $this->assertTrue($charSpace->isWhitespace());
        $this->assertTrue($charTab->isWhitespace());
        $this->assertTrue($charNewline->isWhitespace());
        $this->assertFalse($charA->isWhitespace());
    }

    public function testToUpperCase(): void
    {
        $charA = new Char('a');
        $charZ = new Char('z');
        $char0 = new Char('0');
        $charSpace = new Char(' ');

        $this->assertEquals('A', $charA->toUpperCase()->getValue());
        $this->assertEquals('Z', $charZ->toUpperCase()->getValue());
        $this->assertEquals('0', $char0->toUpperCase()->getValue());
        $this->assertEquals(' ', $charSpace->toUpperCase()->getValue());
    }

    public function testToLowerCase(): void
    {
        $charA = new Char('A');
        $charZ = new Char('Z');
        $char0 = new Char('0');
        $charSpace = new Char(' ');

        $this->assertEquals('a', $charA->toLowerCase()->getValue());
        $this->assertEquals('z', $charZ->toLowerCase()->getValue());
        $this->assertEquals('0', $char0->toLowerCase()->getValue());
        $this->assertEquals(' ', $charSpace->toLowerCase()->getValue());
    }

    public function testGetNumericValue(): void
    {
        $char0 = new Char('0');
        $char9 = new Char('9');
        $charA = new Char('A');

        $this->assertEquals(0, $char0->getNumericValue());
        $this->assertEquals(9, $char9->getNumericValue());
        $this->assertEquals(-1, $charA->getNumericValue());
    }
}
