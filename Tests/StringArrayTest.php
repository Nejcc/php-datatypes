<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidStringException;
use PHPUnit\Framework\TestCase;

final class StringArrayTest extends TestCase
{
    public function testCreateValidStringArray(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);
        $this->assertEquals(['apple', 'banana', 'cherry'], $array->getValue());
    }

    public function testInvalidStringArrayThrowsException(): void
    {
        $this->expectException(InvalidStringException::class);
        new StringArray(['apple', 123, 'cherry']); // Integer value should throw an exception
    }

    public function testAddStringToNewInstance(): void
    {
        $array = new StringArray(['apple', 'banana']);
        $newArray = $array->add('cherry');

        $this->assertNotSame($array, $newArray); // Ensure immutability
        $this->assertEquals(['apple', 'banana'], $array->getValue());
        $this->assertEquals(['apple', 'banana', 'cherry'], $newArray->getValue());
    }

    public function testRemoveStringFromArray(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);
        $newArray = $array->remove('banana');

        $this->assertNotSame($array, $newArray); // Ensure immutability
        $this->assertEquals(['apple', 'banana', 'cherry'], $array->getValue());
        $this->assertEquals(['apple', 'cherry'], $newArray->getValue());
    }

    public function testRemoveNonExistentStringDoesNothing(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);
        $newArray = $array->remove('pear');

        // Check that the values are still the same (immutability)
        $this->assertEquals($array->getValue(), $newArray->getValue());
    }


    public function testContains(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);

        $this->assertTrue($array->contains('banana'));
        $this->assertFalse($array->contains('pear'));
    }

    public function testCountStrings(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);
        $this->assertEquals(3, $array->count());
    }

    public function testToString(): void
    {
        $array = new StringArray(['apple', 'banana', 'cherry']);
        $this->assertEquals('apple, banana, cherry', $array->toString());
        $this->assertEquals('apple|banana|cherry', $array->toString('|'));
    }

    public function testFilterByPrefix(): void
    {
        $array = new StringArray(['apple', 'banana', 'apricot']);
        $filtered = $array->filterByPrefix('ap');

        $this->assertEquals(['apple', 'apricot'], $filtered);
    }

    public function testFilterBySubstring(): void
    {
        $array = new StringArray(['apple', 'banana', 'pineapple']);
        $filtered = $array->filterBySubstring('apple');

        $this->assertEquals(['apple', 'pineapple'], $filtered);
    }

    public function testToUpperCase(): void
    {
        $array = new StringArray(['apple', 'banana']);
        $newArray = $array->toUpperCase();

        $this->assertNotSame($array, $newArray); // Ensure immutability
        $this->assertEquals(['APPLE', 'BANANA'], $newArray->getValue());
    }

    public function testToLowerCase(): void
    {
        $array = new StringArray(['APPLE', 'BANANA']);
        $newArray = $array->toLowerCase();

        $this->assertNotSame($array, $newArray); // Ensure immutability
        $this->assertEquals(['apple', 'banana'], $newArray->getValue());
    }

    public function testClearArray(): void
    {
        $array = new StringArray(['apple', 'banana']);
        $clearedArray = $array->clear();

        $this->assertNotSame($array, $clearedArray); // Ensure immutability
        $this->assertEquals([], $clearedArray->getValue());
    }

    public function testArrayAccess(): void
    {
        $array = new StringArray(['apple', 'banana']);
        $this->assertEquals('apple', $array[0]);
        $this->assertEquals('banana', $array[1]);
        $this->assertNull($array[2]); // Non-existent index
    }

    public function testOffsetSetThrowsException(): void
    {
        $this->expectException(InvalidStringException::class);
        $array = new StringArray(['apple', 'banana']);
        $array[0] = 'orange'; // Should throw an exception
    }

    public function testOffsetUnsetThrowsException(): void
    {
        $this->expectException(InvalidStringException::class);
        $array = new StringArray(['apple', 'banana']);
        unset($array[0]); // Should throw an exception
    }

    public function testIterator(): void
    {
        $array = new StringArray(['apple', 'banana']);
        foreach ($array as $key => $value) {
            $this->assertEquals($array->get($key), $value);
        }
    }
}
