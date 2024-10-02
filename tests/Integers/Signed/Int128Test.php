<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Integers\Signed\Int128;
use Nejcc\PhpDatatypes\Integers\IntegerInterface;
use PHPUnit\Framework\TestCase;

class Int128Test extends TestCase
{
    public function testValidValueInitialization()
    {
        $maxValue = '170141183460469231731687303715884105727';
        $int128 = new Int128($maxValue);
        $this->assertSame($maxValue, $int128->getValue());
    }

    public function testInvalidValueInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        $overflowValue = '170141183460469231731687303715884105728';
        new Int128($overflowValue);
    }

    public function testAdditionWithinBounds()
    {
        $int128a = new Int128('85070591730234615865843651857942052863'); // Half of MAX_VALUE
        $int128b = new Int128('85070591730234615865843651857942052863');
        $int128c = $int128a->add($int128b);

        $expectedResult = '170141183460469231731687303715884105726';
        $this->assertSame($expectedResult, $int128c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);

        $int128a = new Int128('170141183460469231731687303715884105720');
        $int128b = new Int128('10');
        $int128a->add($int128b);
    }

    public function testSubtractionWithinBounds()
    {
        $int128a = new Int128('-85070591730234615865843651857942052863');
        $int128b = new Int128('-85070591730234615865843651857942052863');
        $int128c = $int128a->subtract($int128b);

        $expectedResult = '0';
        $this->assertSame($expectedResult, $int128c->getValue());
    }

    public function testSubtractionUnderflow()
    {
        $this->expectException(\UnderflowException::class);

        $int128a = new Int128('-170141183460469231731687303715884105720');
        $int128b = new Int128('10');
        $int128a->subtract($int128b);
    }

    public function testMultiplicationWithinBounds()
    {
        $int128a = new Int128('1000000000000000000000000000000000000');
        $int128b = new Int128('170141183460469231731687303715884');
        $int128c = $int128a->multiply($int128b);

        $expectedResult = '170141183460469231731687303715884105700000000000000000000000000000000000';
        $this->assertSame($expectedResult, $int128c->getValue());
    }

    public function testMultiplicationOverflow()
    {
        $this->expectException(\OverflowException::class);

        $int128a = new Int128('170141183460469231731687303715884105727');
        $int128b = new Int128('2');
        $int128a->multiply($int128b);
    }

    public function testDivisionWithinBounds()
    {
        $int128a = new Int128('170141183460469231731687303715884105726');
        $int128b = new Int128('2');
        $int128c = $int128a->divide($int128b);

        $expectedResult = '85070591730234615865843651857942052863';
        $this->assertSame($expectedResult, $int128c->getValue());
    }

    public function testDivisionByZero()
    {
        $this->expectException(\DivisionByZeroError::class);

        $int128a = new Int128('1000000000000000000000000000000000000');
        $int128b = new Int128('0');
        $int128a->divide($int128b);
    }

    public function testDivisionResultNotInteger()
    {
        $this->expectException(\UnexpectedValueException::class);

        $int128a = new Int128('5');
        $int128b = new Int128('2');
        $int128a->divide($int128b);
    }

    public function testModulusWithinBounds()
    {
        $int128a = new Int128('170141183460469231731687303715884105726');
        $int128b = new Int128('1000000000000000000000000000000000000');
        $int128c = $int128a->mod($int128b);

        $expectedResult = '726';
        $this->assertSame($expectedResult, $int128c->getValue());
    }

    public function testEquality()
    {
        $int128a = new Int128('12345678901234567890123456789012345678');
        $int128b = new Int128('12345678901234567890123456789012345678');
        $this->assertTrue($int128a->equals($int128b));
    }

    public function testInequality()
    {
        $int128a = new Int128('12345678901234567890123456789012345678');
        $int128b = new Int128('12345678901234567890123456789012345679');
        $this->assertFalse($int128a->equals($int128b));
    }

    public function testComparison()
    {
        $int128a = new Int128('12345678901234567890123456789012345678');
        $int128b = new Int128('12345678901234567890123456789012345679');

        $this->assertSame(-1, $int128a->compare($int128b));
        $this->assertSame(1, $int128b->compare($int128a));

        $int128c = new Int128('12345678901234567890123456789012345678');
        $this->assertSame(0, $int128a->compare($int128c));
    }
}
