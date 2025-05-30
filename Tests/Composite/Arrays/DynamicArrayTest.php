<?php

declare(strict_types=1);

namespace Tests\Composite\Arrays;

use Nejcc\PhpDatatypes\Composite\Arrays\DynamicArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;
use PHPUnit\Framework\TestCase;

final class DynamicArrayTest extends TestCase
{
    public function testCreateDynamicArray()
    {
        $array = new DynamicArray(\stdClass::class, 4);
        $this->assertEquals(4, $array->getCapacity());
        $this->assertEquals(0, count($array));
    }

    public function testCreateWithInvalidCapacity()
    {
        $this->expectException(InvalidArgumentException::class);
        new DynamicArray(\stdClass::class, 0);
    }

    public function testCreateWithInitialData()
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array = new DynamicArray(\stdClass::class, 2, [$obj1, $obj2]);
        $this->assertEquals(2, count($array));
        $this->assertEquals(2, $array->getCapacity());
    }

    public function testCreateWithExcessiveInitialData()
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = new \stdClass();
        $array = new DynamicArray(\stdClass::class, 2, [$obj1, $obj2, $obj3]);
        $this->assertEquals(3, count($array));
        $this->assertEquals(3, $array->getCapacity());
    }

    public function testReserveCapacity()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $array->reserve(10);
        $this->assertEquals(10, $array->getCapacity());
        $array->reserve(5); // Should not decrease
        $this->assertEquals(10, $array->getCapacity());
    }

    public function testShrinkToFit()
    {
        $array = new DynamicArray(\stdClass::class, 10);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array[] = $obj1;
        $array[] = $obj2;
        $this->assertEquals(10, $array->getCapacity());
        $array->shrinkToFit();
        $this->assertEquals(2, $array->getCapacity());
    }

    public function testDynamicResizingOnAppend()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = new \stdClass();
        $array[] = $obj1;
        $array[] = $obj2;
        $this->assertEquals(2, $array->getCapacity());
        $array[] = $obj3;
        $this->assertEquals(4, $array->getCapacity());
        $this->assertEquals(3, count($array));
    }

    public function testDynamicResizingOnOffsetSet()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $obj = new \stdClass();
        $array[5] = $obj;
        $this->assertEquals(6, $array->getCapacity());
        $this->assertSame($obj, $array[5]);
    }

    public function testSetInvalidType()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $this->expectException(TypeMismatchException::class);
        $array[] = "not an object";
    }

    public function testSetValueAdjustsCapacity()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = new \stdClass();
        $array->setValue([$obj1, $obj2, $obj3]);
        $this->assertEquals(3, $array->getCapacity());
        $this->assertEquals(3, count($array));
    }

    public function testIteration()
    {
        $array = new DynamicArray(\stdClass::class, 2);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array[] = $obj1;
        $array[] = $obj2;
        $elements = [];
        foreach ($array as $element) {
            $elements[] = $element;
        }
        $this->assertCount(2, $elements);
        $this->assertSame($obj1, $elements[0]);
        $this->assertSame($obj2, $elements[1]);
    }
}
