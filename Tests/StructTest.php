<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use PHPUnit\Framework\TestCase;

class StructTest extends TestCase
{
    public function testConstructionAndFieldRegistration(): void
    {
        $struct = new Struct([
            'id' => 'int',
            'name' => 'string',
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
            'id' => 'int',
            'name' => 'string',
        ]);
        $struct->set('id', 42);
        $struct->set('name', 'Alice');
        $this->assertSame(42, $struct->get('id'));
        $this->assertSame('Alice', $struct->get('name'));
    }

    public function testSetWrongTypeThrows(): void
    {
        $struct = new Struct([
            'id' => 'int',
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->set('id', 'not an int');
    }

    public function testSetNullableField(): void
    {
        $struct = new Struct([
            'desc' => '?string',
        ]);
        $struct->set('desc', null);
        $this->assertNull($struct->get('desc'));
        $struct->set('desc', 'hello');
        $this->assertSame('hello', $struct->get('desc'));
    }

    public function testSetNonNullableFieldNullThrows(): void
    {
        $struct = new Struct([
            'id' => 'int',
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->set('id', null);
    }

    public function testSetSubclass(): void
    {
        $struct = new Struct([
            'obj' => 'stdClass',
        ]);
        $obj = new class extends \stdClass {};
        $struct->set('obj', $obj);
        $this->assertSame($obj, $struct->get('obj'));
    }

    public function testGetNonexistentFieldThrows(): void
    {
        $struct = new Struct([
            'id' => 'int',
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->get('missing');
    }

    public function testSetNonexistentFieldThrows(): void
    {
        $struct = new Struct([
            'id' => 'int',
        ]);
        $this->expectException(InvalidArgumentException::class);
        $struct->set('missing', 123);
    }

    public function testDuplicateFieldThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        // Simulate duplicate by calling addField directly via reflection
        $struct = new Struct(['id' => 'int']);
        $ref = new \ReflectionClass($struct);
        $method = $ref->getMethod('addField');
        $method->setAccessible(true);
        $method->invoke($struct, 'id', 'int');
    }

    public function testMagicGetSet(): void
    {
        $struct = new Struct([
            'foo' => 'int',
        ]);
        $struct->foo = 123;
        $this->assertSame(123, $struct->foo);
    }
}
