<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Floats;

use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use PHPUnit\Framework\TestCase;

final class Float32Test extends TestCase
{
    public function testSetAndGetValue(): void
    {
        $float = float32(1.234567e10);
        $this->assertEquals(1.234567e10, $float->getValue());
    }

    public function testOutOfRangeException(): void
    {
        // Expect the exception to be thrown before the code that triggers it.
        $this->expectException(\OutOfRangeException::class);

        // Now trigger the exception with an out-of-range value.
        \float32(4.0e38); // This value is beyond Float32's range.
    }

}
