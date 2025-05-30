<?php

declare(strict_types=1);

namespace Tests\Composite\Arrays;

use Nejcc\PhpDatatypes\Composite\Arrays\FixedSizeArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;
use PHPUnit\Framework\TestCase;

final class FixedSizeArrayTest extends TestCase
{
    public function testCreateFixedSizeArray()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $this->assertEquals(3, $array->getSize());
        $this->assertEquals(0, count($array));
        $this->assertTrue($array->isEmpty());
        $this->assertFalse($array->isFull());
        $this->assertEquals(3, $array->getRemainingSlots());
    }

    public function testCreateWithInvalidSize()
    {
        $this->expectException(InvalidArgumentException::class);
        new FixedSizeArray(\stdClass::class, 0);
    }

    public function testCreateWithInitialData()
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array = new FixedSizeArray(\stdClass::class, 3, [$obj1, $obj2]);

        $this->assertEquals(2, count($array));
        $this->assertFalse($array->isEmpty());
        $this->assertFalse($array->isFull());
        $this->assertEquals(1, $array->getRemainingSlots());
    }

    public function testCreateWithExcessiveInitialData()
    {
        $this->expectException(InvalidArgumentException::class);
        new FixedSizeArray(\stdClass::class, 2, [new \stdClass(), new \stdClass(), new \stdClass()]);
    }

    public function testAddElements()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();

        $array[] = $obj1;
        $array[] = $obj2;

        $this->assertEquals(2, count($array));
        $this->assertSame($obj1, $array[0]);
        $this->assertSame($obj2, $array[1]);
    }

    public function testAddElementWhenFull()
    {
        $array = new FixedSizeArray(\stdClass::class, 2);
        $array[] = new \stdClass();
        $array[] = new \stdClass();

        $this->expectException(InvalidArgumentException::class);
        $array[] = new \stdClass();
    }

    public function testSetElementOutOfBounds()
    {
        $array = new FixedSizeArray(\stdClass::class, 2);

        $this->expectException(InvalidArgumentException::class);
        $array[2] = new \stdClass();
    }

    public function testSetInvalidType()
    {
        $array = new FixedSizeArray(\stdClass::class, 2);

        $this->expectException(TypeMismatchException::class);
        $array[] = "not an object";
    }

    public function testFillArray()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $obj = new \stdClass();

        $array->fill($obj);

        $this->assertEquals(3, count($array));
        $this->assertTrue($array->isFull());
        $this->assertEquals(0, $array->getRemainingSlots());

        foreach ($array as $element) {
            $this->assertSame($obj, $element);
        }
    }

    public function testFillWithInvalidType()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);

        $this->expectException(TypeMismatchException::class);
        $array->fill("not an object");
    }

    public function testSetValue()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();

        $array->setValue([$obj1, $obj2]);

        $this->assertEquals(2, count($array));
        $this->assertSame($obj1, $array[0]);
        $this->assertSame($obj2, $array[1]);
    }

    public function testSetValueExceedsSize()
    {
        $array = new FixedSizeArray(\stdClass::class, 2);

        $this->expectException(InvalidArgumentException::class);
        $array->setValue([new \stdClass(), new \stdClass(), new \stdClass()]);
    }

    public function testCreateEmpty()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $empty = $array->createEmpty();

        $this->assertInstanceOf(FixedSizeArray::class, $empty);
        $this->assertEquals(3, $empty->getSize());
        $this->assertEquals(0, count($empty));
        $this->assertEquals(\stdClass::class, $empty->getElementType());
    }

    public function testIteration()
    {
        $array = new FixedSizeArray(\stdClass::class, 3);
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = new \stdClass();

        $array[] = $obj1;
        $array[] = $obj2;
        $array[] = $obj3;

        $elements = [];
        foreach ($array as $element) {
            $elements[] = $element;
        }

        $this->assertCount(3, $elements);
        $this->assertSame($obj1, $elements[0]);
        $this->assertSame($obj2, $elements[1]);
        $this->assertSame($obj3, $elements[2]);
    }
}
