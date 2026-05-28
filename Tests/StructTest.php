<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use PHPUnit\Framework\TestCase;

final class StructTest extends TestCase
{
    public function testConstructionAndFieldRegistration(): void
    {
        $struct = new Struct([
            'id' => ['type' => 'int', 'nullable' => true],
            'name' => ['type' => 'string', 'nullable' => true],
        ]);
        $fields = $struct->getFields();
        $this->assertArrayHasKey('id', $fields);
        $this->assertArrayHasKey('name', $fields);
        $this->assertSame('int', $fields['id']['type']);
        $this->assertSame('string', $fields['name']['type']);
        $this->assertNull($fields['id']['value']);
        $this->assertNull($fields['name']['value']);
    }

    public function testSetAndGet(): void
    {
        $struct = new Struct([
            'id' => ['type' => 'int', 'nullable' => true],
            'name' => ['type' => 'string', 'nullable' => true],
        ]);
        $struct->set('id', 42);
        $struct->set('name', 'Alice');
        $this->assertSame(42, $struct->get('id'));
        $this->assertSame('Alice', $struct->get('name'));
    }

    public function testSetWrongTypeThrows(): void
    {
        $struct = new Struct([
            'id' => ['type' => 'int', 'nullable' => true],
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->set('id', 'not an int');
    }

    public function testSetNullableField(): void
    {
        $struct = new Struct([
            'desc' => ['type' => 'string', 'nullable' => true],
        ]);
        $struct->set('desc', null);
        $this->assertNull($struct->get('desc'));
        $struct->set('desc', 'hello');
        $this->assertSame('hello', $struct->get('desc'));
    }

    public function testSetNonNullableFieldNullThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field 'id' is required and has no value");
        new Struct([
            'id' => ['type' => 'int', 'nullable' => false],
        ]);
    }

    public function testSetSubclass(): void
    {
        $struct = new Struct([
            'obj' => ['type' => 'stdClass', 'nullable' => true],
        ]);
        $obj = new class () extends \stdClass {};
        $struct->set('obj', $obj);
        $this->assertSame($obj, $struct->get('obj'));
    }

    public function testGetNonexistentFieldThrows(): void
    {
        $struct = new Struct([
            'id' => ['type' => 'int', 'nullable' => true],
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->get('missing');
    }

    public function testSetNonexistentFieldThrows(): void
    {
        $struct = new Struct([
            'id' => ['type' => 'int', 'nullable' => true],
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->set('missing', 123);
    }

    public function testDuplicateFieldThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        // Simulate duplicate by calling addField directly via reflection
        $struct = new Struct(['id' => ['type' => 'int', 'nullable' => true]]);
        $ref = new \ReflectionClass($struct);
        $method = $ref->getMethod('addField');
        $method->setAccessible(true);
        $method->invoke($struct, 'id', 'int');
    }

    public function testMagicGetSet(): void
    {
        $struct = new Struct([
            'foo' => ['type' => 'int', 'nullable' => true],
        ]);
        $struct->foo = 123;
        $this->assertSame(123, $struct->foo);
    }
}
