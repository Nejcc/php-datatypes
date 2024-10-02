<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Integers\IntegerInterface;
use PHPUnit\Framework\TestCase;

class Int64Test extends TestCase
{
    public function testValidValueInitialization()
    {
        $maxValue = '9223372036854775807';
        $int64 = new Int64($maxValue);
        $this->assertSame($maxValue, $int64->getValue());
    }

    public function testInvalidValueInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        $overflowValue = '9223372036854775808';
        new Int64($overflowValue);
    }

    public function testAdditionWithinBounds()
    {
        $int64a = new Int64('5000000000000000000');
        $int64b = new Int64('4000000000000000000');
        $int64c = $int64a->add($int64b);
        $this->assertSame('9000000000000000000', $int64c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int64a = new Int64('9223372036854775800');
        $int64b = new Int64('10');
        $int64a->add($int64b);
    }

    // Add tests for subtraction, multiplication, division, modulus, equality, and comparison
}
