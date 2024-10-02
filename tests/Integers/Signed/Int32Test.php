<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Integers\Signed;

use Nejcc\PhpDatatypes\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Integers\IntegerInterface;
use PHPUnit\Framework\TestCase;

class Int32Test extends TestCase
{
    public function testValidValueInitialization()
    {
        $int32 = new Int32(2147483647);
        $this->assertSame(2147483647, $int32->getValue());
    }

    public function testInvalidValueInitialization()
    {
        $this->expectException(\OutOfRangeException::class);
        new Int32(2147483648);
    }

    public function testAdditionWithinBounds()
    {
        $int32a = new Int32(1000000000);
        $int32b = new Int32(1000000000);
        $int32c = $int32a->add($int32b);
        $this->assertSame(2000000000, $int32c->getValue());
    }

    public function testAdditionOverflow()
    {
        $this->expectException(\OverflowException::class);
        $int32a = new Int32(2000000000);
        $int32b = new Int32(2000000000);
        $int32a->add($int32b);
    }

    // Add tests for subtraction, multiplication, division, modulus, equality, and comparison
}
