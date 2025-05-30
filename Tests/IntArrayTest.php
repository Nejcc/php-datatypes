<?php

declare(strict_types=1);

use Nejcc\PhpDatatypes\Composite\Arrays\IntArray;
use PHPUnit\Framework\TestCase;

class IntArrayTest extends TestCase
{
    public function testConstructionAndGet(): void
    {
        $arr = new IntArray([1, 2, 3, 4]);
        $this->assertSame(1, $arr->get(0));
        $this->assertSame(4, $arr->get(3));
    }

    public function testSetAndGet(): void
    {
        $arr = new IntArray([1, 2, 3]);
        $arr->set(1, 42);
        $this->assertSame(42, $arr->get(1));
    }

    public function testCount(): void
    {
        $arr = new IntArray([1, 2, 3, 4, 5]);
        $this->assertCount(5, $arr);
    }

    public function testIteration(): void
    {
        $arr = new IntArray([10, 20, 30]);
        $result = [];
        foreach ($arr as $value) {
            $result[] = $value;
        }
        $this->assertSame([10, 20, 30], $result);
    }

    public function testToArray(): void
    {
        $arr = new IntArray([7, 8, 9]);
        $this->assertSame([7, 8, 9], $arr->toArray());
    }

    public function testInvalidIndexGet(): void
    {
        $arr = new IntArray([1, 2, 3]);
        $this->expectException(\OutOfRangeException::class);
        $arr->get(10);
    }

    public function testInvalidIndexSet(): void
    {
        $arr = new IntArray([1, 2, 3]);
        $this->expectException(\OutOfRangeException::class);
        $arr->set(10, 5);
    }

    public function testInvalidValueType(): void
    {
        $arr = new IntArray([1, 2, 3]);
        $this->expectException(\TypeError::class);
        $arr->set(0, 'not an int');
    }

    public function testAppend(): void
    {
        $arr = new IntArray([1, 2]);
        $arr->append(3);
        $this->assertSame([1, 2, 3], $arr->toArray());
    }

    public function testAppendInvalidType(): void
    {
        $arr = new IntArray([1, 2, 3]);
        $this->expectException(\TypeError::class);
        $arr->append('not an int');
    }
} 