<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use PHPUnit\Framework\TestCase;

class StructTest extends TestCase
{
    public function testStructSetAndGet()
    {
        // Example 1
        $struct = new Struct([
            'name' => 'string',
            'age' => '?int',
            'balance' => 'float',
        ]);

        // Test setting and getting field values using set/get methods
        $struct->set('name', 'Nejc');
        $struct->set('age', null); // Nullable type
        $struct->set('balance', 100.50);

        // Assertions
        $this->assertEquals('Nejc', $struct->get('name'));
        $this->assertNull($struct->get('age'));
        $this->assertEquals(100.50, $struct->get('balance'));
    }

    public function testMagicMethods()
    {
        // Example 1 with magic methods
        $struct = new Struct([
            'name' => 'string',
            'age' => '?int',
            'balance' => 'float',
        ]);

        // Test setting and getting field values using magic methods
        $struct->name = 'John';
        $struct->age = null;
        $struct->balance = 200.75;

        // Assertions
        $this->assertEquals('John', $struct->name);
        $this->assertNull($struct->age);
        $this->assertEquals(200.75, $struct->balance);
    }

    public function testStructHelperFunction()
    {
        // Example 2: using the `struct()` helper function (assuming it is defined)
        $struct = struct([
            'name' => 'string',
            'age' => '?int',
            'balance' => 'float',
        ]);

        // Test setting and getting field values using set/get methods
        $struct->set('name', 'Test');
        $struct->set('age', null);
        $struct->set('balance', 100.50);

        // Assertions
        $this->assertEquals('Test', $struct->get('name'));
        $this->assertNull($struct->get('age'));
        $this->assertEquals(100.50, $struct->get('balance'));
    }

    public function testInvalidFieldThrowsException()
    {
        $struct = new Struct([
            'name' => 'string',
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field 'age' does not exist in the struct.");

        $struct->set('age', 25); // This should throw an exception
    }

    public function testInvalidTypeThrowsException()
    {
        $struct = new Struct([
            'name' => 'string',
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field 'name' expects type 'string', but got 'int'.");

        $struct->set('name', 123); // Invalid type
    }
}
