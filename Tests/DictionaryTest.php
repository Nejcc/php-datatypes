<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Dictionary;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

final class DictionaryTest extends TestCase
{
    public function testCanInitializeWithElements()
    {
        $dictionary = new Dictionary([
            'name' => 'John Doe',
            'age' => 30,
        ]);

        $this->assertEquals('John Doe', $dictionary->get('name'));
        $this->assertEquals(30, $dictionary->get('age'));
    }

    public function testAddAndGetElements()
    {
        $dictionary = new Dictionary();
        $dictionary->add('name', 'Alice');
        $dictionary->add('age', 25);

        $this->assertEquals('Alice', $dictionary->get('name'));
        $this->assertEquals(25, $dictionary->get('age'));
    }

    public function testContainsKey()
    {
        $dictionary = new Dictionary([
            'name' => 'Bob',
        ]);

        $this->assertTrue($dictionary->containsKey('name'));
        $this->assertFalse($dictionary->containsKey('age'));
    }

    public function testRemoveElement()
    {
        $dictionary = new Dictionary([
            'name' => 'Charlie',
            'age' => 40,
        ]);

        $dictionary->remove('age');
        $this->assertFalse($dictionary->containsKey('age'));
        $this->assertEquals('Charlie', $dictionary->get('name'));

        $this->expectException(OutOfBoundsException::class);
        $dictionary->get('age'); // This should throw an exception as 'age' was removed
    }

    public function testGetKeysAndValues()
    {
        $dictionary = new Dictionary([
            'name' => 'David',
            'age' => 35,
            'country' => 'UK',
        ]);

        $this->assertEquals(['name', 'age', 'country'], $dictionary->getKeys());
        $this->assertEquals(['David', 35, 'UK'], $dictionary->getValues());
    }

    public function testDictionarySize()
    {
        $dictionary = new Dictionary([
            'name' => 'Eve',
            'city' => 'Berlin',
        ]);

        $this->assertEquals(2, $dictionary->size());

        $dictionary->add('age', 28);
        $this->assertEquals(3, $dictionary->size());
    }

    public function testClearDictionary()
    {
        $dictionary = new Dictionary([
            'name' => 'Frank',
            'job' => 'Developer',
        ]);

        $dictionary->clear();

        $this->assertEquals(0, $dictionary->size());
        $this->assertFalse($dictionary->containsKey('name'));
    }

    public function testInvalidKeyThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Dictionary keys must be non-integer (string) keys.");

        // Attempt to initialize with an invalid key (integer key)
        new Dictionary([1 => 'Invalid']);
    }

    public function testGetNonExistentKeyThrowsException()
    {
        $dictionary = new Dictionary(['name' => 'Grace']);
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Key 'age' does not exist in the dictionary.");

        $dictionary->get('age'); // This should throw an exception
    }

    public function testRemoveNonExistentKeyThrowsException()
    {
        $dictionary = new Dictionary(['name' => 'Hank']);
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Key 'age' does not exist in the dictionary.");

        $dictionary->remove('age'); // This should throw an exception
    }
}
