<?php

declare(strict_types=1);

namespace Tests\Composite\Arrays;

use Nejcc\PhpDatatypes\Composite\Arrays\TypeSafeArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;
use PHPUnit\Framework\TestCase;

final class TypeSafeArrayTest extends TestCase
{
    public function testCreateValidTypeSafeArray(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $this->assertInstanceOf(TypeSafeArray::class, $array);
        $this->assertEquals(\stdClass::class, $array->getElementType());
    }

    public function testCreateWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new TypeSafeArray('NonExistentClass');
    }

    public function testAddValidElement(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj = new \stdClass();
        $array[] = $obj;
        $this->assertCount(1, $array);
        $this->assertSame($obj, $array[0]);
    }

    public function testAddInvalidElement(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $this->expectException(TypeMismatchException::class);
        $array[] = 'not an object';
    }

    public function testInitializeWithValidData(): void
    {
        $data = [new \stdClass(), new \stdClass()];
        $array = new TypeSafeArray(\stdClass::class, $data);
        $this->assertCount(2, $array);
    }

    public function testInitializeWithInvalidData(): void
    {
        $data = [new \stdClass(), 'not an object'];
        $this->expectException(TypeMismatchException::class);
        new TypeSafeArray(\stdClass::class, $data);
    }

    public function testMapOperation(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array[] = $obj1;
        $array[] = $obj2;

        $mapped = $array->map(function ($item) {
            $new = new \stdClass();
            $new->mapped = true;
            return $new;
        });

        $this->assertInstanceOf(TypeSafeArray::class, $mapped);
        $this->assertCount(2, $mapped);
        $this->assertTrue($mapped[0]->mapped);
        $this->assertTrue($mapped[1]->mapped);
    }

    public function testFilterOperation(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj1 = new \stdClass();
        $obj1->value = 1;
        $obj2 = new \stdClass();
        $obj2->value = 2;
        $array[] = $obj1;
        $array[] = $obj2;

        $filtered = $array->filter(function ($item) {
            return $item->value === 1;
        });

        $this->assertInstanceOf(TypeSafeArray::class, $filtered);
        $this->assertCount(1, $filtered);
        $this->assertEquals(1, $filtered[0]->value);
    }

    public function testReduceOperation(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj1 = new \stdClass();
        $obj1->value = 1;
        $obj2 = new \stdClass();
        $obj2->value = 2;
        $array[] = $obj1;
        $array[] = $obj2;

        $sum = $array->reduce(function ($carry, $item) {
            return $carry + $item->value;
        }, 0);

        $this->assertEquals(3, $sum);
    }

    public function testArrayAccess(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj = new \stdClass();

        // Test offsetSet
        $array[0] = $obj;
        $this->assertTrue(isset($array[0]));
        $this->assertSame($obj, $array[0]);

        // Test offsetUnset
        unset($array[0]);
        $this->assertFalse(isset($array[0]));
    }

    public function testIterator(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array[] = $obj1;
        $array[] = $obj2;

        $items = [];
        foreach ($array as $item) {
            $items[] = $item;
        }

        $this->assertCount(2, $items);
        $this->assertSame($obj1, $items[0]);
        $this->assertSame($obj2, $items[1]);
    }

    public function testToString(): void
    {
        $array = new TypeSafeArray(\stdClass::class);
        $obj = new \stdClass();
        $obj->test = 'value';
        $array[] = $obj;

        $this->assertEquals('[{"test":"value"}]', (string)$array);
    }
}
