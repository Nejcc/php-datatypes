<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Composite\Arrays\FloatArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidFloatException;
use PHPUnit\Framework\TestCase;

final class FloatArrayTest extends TestCase
{
    /**
     * Test creating a valid FloatArray instance.
     *
     * @throws InvalidFloatException
     */
    public function testCreateValidFloatArray(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $this->assertSame([10.5, 20.1, 30.7], $floatArray->getValue());
    }

    /**
     * Test creating a FloatArray with invalid float values.
     */
    public function testCreateInvalidFloatArray(): void
    {
        $this->expectException(InvalidFloatException::class);
        $this->expectExceptionMessage("All elements must be floats. Invalid value: 1");

        new FloatArray([10.5, 1, 'not a float']); // Invalid non-float values
    }

    /**
     * Test adding floats to a FloatArray.
     *
     * @throws InvalidFloatException
     */
    public function testAddFloats(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $newFloatArray = $floatArray->add(40.2, 50.3);

        $this->assertSame([10.5, 20.1, 30.7, 40.2, 50.3], $newFloatArray->getValue());
    }

    /**
     * Test removing floats from a FloatArray.
     *
     * @throws InvalidFloatException
     */
    public function testRemoveFloats(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7, 40.2]);
        $modifiedFloatArray = $floatArray->remove(20.1, 30.7);

        $this->assertSame([10.5, 40.2], $modifiedFloatArray->getValue());
    }

    /**
     * Test calculating the sum of floats.
     *
     * @throws InvalidFloatException
     */
    public function testSumOfFloats(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $this->assertSame(61.3, $floatArray->sum());
    }

    /**
     * Test calculating the average of floats.
     *
     * @throws InvalidFloatException
     */
    public function testAverageOfFloats(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $this->assertSame(20.433333333333334, $floatArray->average());
    }

    /**
     * Test calculating the average of an empty FloatArray.
     */
    public function testAverageOfEmptyFloatArray(): void
    {
        $this->expectException(InvalidFloatException::class);
        $this->expectExceptionMessage("Cannot calculate average of an empty array.");

        $floatArray = new FloatArray([]);
        $floatArray->average(); // Should throw exception
    }

    /**
     * Test getting the count of floats in a FloatArray.
     *
     * @throws InvalidFloatException
     */
    public function testGetFloatCount(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $this->assertCount(3, $floatArray);
    }

    /**
     * Test ArrayAccess implementation for accessing a float at a specific index.
     *
     * @throws InvalidFloatException
     */
    public function testArrayAccessGet(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $this->assertSame(20.1, $floatArray[1]);
        $this->assertNull($floatArray[999]); // Accessing an invalid index returns null
    }

    /**
     * Test ArrayAccess prevents modification of FloatArray.
     */
    public function testArrayAccessSetThrowsException(): void
    {
        $this->expectException(InvalidFloatException::class);
        $this->expectExceptionMessage("Cannot modify an immutable FloatArray.");

        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $floatArray[1] = 50.3; // Should throw exception
    }

    /**
     * Test ArrayAccess prevents unsetting a float in FloatArray.
     */
    public function testArrayAccessUnsetThrowsException(): void
    {
        $this->expectException(InvalidFloatException::class);
        $this->expectExceptionMessage("Cannot unset a value in an immutable FloatArray.");

        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        unset($floatArray[1]); // Should throw exception
    }

    /**
     * Test iterating over FloatArray with IteratorAggregate.
     *
     * @throws InvalidFloatException
     */
    public function testIterationOverFloatArray(): void
    {
        $floatArray = new FloatArray([10.5, 20.1, 30.7]);
        $result = [];

        foreach ($floatArray as $float) {
            $result[] = $float;
        }

        $this->assertSame([10.5, 20.1, 30.7], $result);
    }

    /**
     * Test creating an empty FloatArray.
     *
     * @throws InvalidFloatException
     */
    public function testEmptyFloatArray(): void
    {
        $floatArray = new FloatArray([]);
        $this->assertSame([], $floatArray->getValue());
        $this->assertCount(0, $floatArray);
    }
}
