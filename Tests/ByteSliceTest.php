<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;
use Nejcc\PhpDatatypes\Exceptions\InvalidByteException;
use PHPUnit\Framework\TestCase;

final class ByteSliceTest extends TestCase
{
    /**
     * Test creating a valid ByteSlice instance.
     */
    public function testCreateValidByteSlice(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255]);
        $this->assertSame([10, 20, 255], $byteSlice->getValue());
    }

    /**
     * Test creating a ByteSlice with invalid byte values.
     */
    public function testCreateInvalidByteSlice(): void
    {
        $this->expectException(InvalidByteException::class);
        $this->expectExceptionMessage("All elements must be valid bytes (0-255). Invalid value: -1");

        new ByteSlice([10, -1, 255]); // -1 is out of valid byte range
    }

    /**
     * Test converting ByteSlice to hexadecimal representation.
     */
    public function testConvertToHexadecimal(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255]);
        $this->assertSame("0A14FF", $byteSlice->toHex());
    }

    /**
     * Test slicing a portion of ByteSlice.
     */
    public function testSliceByteSlice(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255, 30, 40]);
        $sliced = $byteSlice->slice(1, 3);
        $this->assertSame([20, 255, 30], $sliced->getValue());
    }

    /**
     * Test merging two ByteSlices.
     */
    public function testMergeByteSlices(): void
    {
        $byteSlice1 = new ByteSlice([10, 20, 255]);
        $byteSlice2 = new ByteSlice([1, 2, 3]);
        $merged = $byteSlice1->merge($byteSlice2);

        $this->assertSame([10, 20, 255, 1, 2, 3], $merged->getValue());
    }

    /**
     * Test getting the count of bytes in a ByteSlice.
     */
    public function testGetByteCount(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255]);
        $this->assertCount(3, $byteSlice);
    }

    /**
     * Test ArrayAccess implementation for accessing a byte at a specific index.
     */
    public function testArrayAccessGet(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255]);
        $this->assertSame(20, $byteSlice[1]);
        $this->assertNull($byteSlice[999]); // Accessing an invalid index returns null
    }

    /**
     * Test ArrayAccess prevents modification of ByteSlice.
     */
    public function testArrayAccessSetThrowsException(): void
    {
        $this->expectException(InvalidByteException::class);
        $this->expectExceptionMessage("Cannot modify an immutable ByteSlice.");

        $byteSlice = new ByteSlice([10, 20, 255]);
        $byteSlice[1] = 100; // Should throw an exception
    }

    /**
     * Test ArrayAccess prevents unsetting a byte in ByteSlice.
     */
    public function testArrayAccessUnsetThrowsException(): void
    {
        $this->expectException(InvalidByteException::class);
        $this->expectExceptionMessage("Cannot unset a value in an immutable ByteSlice.");

        $byteSlice = new ByteSlice([10, 20, 255]);
        unset($byteSlice[1]); // Should throw an exception
    }

    /**
     * Test iterating over ByteSlice with IteratorAggregate.
     */
    public function testIterationOverByteSlice(): void
    {
        $byteSlice = new ByteSlice([10, 20, 255]);
        $result = [];

        foreach ($byteSlice as $byte) {
            $result[] = $byte;
        }

        $this->assertSame([10, 20, 255], $result);
    }

    /**
     * Test an empty ByteSlice.
     */
    public function testEmptyByteSlice(): void
    {
        $byteSlice = new ByteSlice([]);
        $this->assertSame([], $byteSlice->getValue());
        $this->assertCount(0, $byteSlice);
    }
}
