<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use PHPUnit\Framework\TestCase;
use TypeError;

class StringArrayTest extends TestCase
{
    /**
     * Test that the constructor throws an exception if any element is not a string.
     */
    public function testConstructorThrowsExceptionForInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        new StringArray(['validString', 123]); // Invalid, second element is an integer
    }

    /**
     * Test that the constructor correctly assigns the array of strings.
     */
    public function testConstructorAssignsValidValue()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $this->assertEquals(['string1', 'string2'], $stringArray->getValue());
    }

    /**
     * Test that adding a valid string works.
     */
    public function testAddString()
    {
        $stringArray = new StringArray(['string1']);
        $stringArray->add('string2');
        $this->assertEquals(['string1', 'string2'], $stringArray->getValue());
    }

    /**
     * Test that adding a non-string value throws a TypeError.
     */
    public function testAddNonStringThrowsException()
    {
        $stringArray = new StringArray(['string1']);

        $this->expectException(TypeError::class);  // Expect TypeError instead of InvalidArgumentException
        $stringArray->add(123); // Invalid, not a string
    }

    /**
     * Test that removing an existing string works.
     */
    public function testRemoveString()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $removed = $stringArray->remove('string1');

        $this->assertTrue($removed);
        $this->assertEquals(['string2'], $stringArray->getValue());
    }

    /**
     * Test that removing a non-existing string returns false.
     */
    public function testRemoveNonExistingString()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $removed = $stringArray->remove('string3');

        $this->assertFalse($removed);
        $this->assertEquals(['string1', 'string2'], $stringArray->getValue());
    }

    /**
     * Test that contains() works correctly.
     */
    public function testContainsString()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $this->assertTrue($stringArray->contains('string1'));
        $this->assertFalse($stringArray->contains('string3'));
    }

    /**
     * Test that count() returns the correct number of elements.
     */
    public function testCountStrings()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $this->assertEquals(2, $stringArray->count());
    }

    /**
     * Test that toString() returns the correct comma-separated string.
     */
    public function testToString()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $this->assertEquals('string1, string2', $stringArray->toString());
    }

    /**
     * Test that clear() empties the array.
     */
    public function testClearArray()
    {
        $stringArray = new StringArray(['string1', 'string2']);
        $stringArray->clear();
        $this->assertEquals([], $stringArray->getValue());
    }
}
