<?php

namespace Tests\Composite\Vector;

use Nejcc\PhpDatatypes\Composite\Vector\Vec3;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class Vec3Test extends TestCase
{
    public function testCreateValidVec3(): void
    {
        $vec = new Vec3([1.0, 2.0, 3.0]);
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(2.0, $vec->getY());
        $this->assertEquals(3.0, $vec->getZ());
    }

    public function testCreateInvalidComponentCount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec3([1.0, 2.0]);
    }

    public function testCreateWithNonNumericComponents(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec3(['a', 'b', 'c']);
    }

    public function testMagnitude(): void
    {
        $vec = new Vec3([1.0, 2.0, 2.0]);
        $this->assertEquals(3.0, $vec->magnitude());
    }

    public function testNormalize(): void
    {
        $vec = new Vec3([1.0, 2.0, 2.0]);
        $normalized = $vec->normalize();
        $this->assertEquals(1.0, $normalized->magnitude());
        $this->assertEquals(1/3, $normalized->getX());
        $this->assertEquals(2/3, $normalized->getY());
        $this->assertEquals(2/3, $normalized->getZ());
    }

    public function testNormalizeZeroVector(): void
    {
        $vec = new Vec3([0.0, 0.0, 0.0]);
        $this->expectException(InvalidArgumentException::class);
        $vec->normalize();
    }

    public function testDotProduct(): void
    {
        $vec1 = new Vec3([1.0, 2.0, 3.0]);
        $vec2 = new Vec3([4.0, 5.0, 6.0]);
        $this->assertEquals(32.0, $vec1->dot($vec2));
    }

    public function testAdd(): void
    {
        $vec1 = new Vec3([1.0, 2.0, 3.0]);
        $vec2 = new Vec3([4.0, 5.0, 6.0]);
        $result = $vec1->add($vec2);
        $this->assertEquals(5.0, $result->getX());
        $this->assertEquals(7.0, $result->getY());
        $this->assertEquals(9.0, $result->getZ());
    }

    public function testSubtract(): void
    {
        $vec1 = new Vec3([4.0, 5.0, 6.0]);
        $vec2 = new Vec3([1.0, 2.0, 3.0]);
        $result = $vec1->subtract($vec2);
        $this->assertEquals(3.0, $result->getX());
        $this->assertEquals(3.0, $result->getY());
        $this->assertEquals(3.0, $result->getZ());
    }

    public function testScale(): void
    {
        $vec = new Vec3([1.0, 2.0, 3.0]);
        $result = $vec->scale(2.0);
        $this->assertEquals(2.0, $result->getX());
        $this->assertEquals(4.0, $result->getY());
        $this->assertEquals(6.0, $result->getZ());
    }

    public function testCross(): void
    {
        $vec1 = new Vec3([1.0, 0.0, 0.0]);
        $vec2 = new Vec3([0.0, 1.0, 0.0]);
        $result = $vec1->cross($vec2);
        $this->assertEquals(0.0, $result->getX());
        $this->assertEquals(0.0, $result->getY());
        $this->assertEquals(1.0, $result->getZ());
    }

    public function testZero(): void
    {
        $vec = Vec3::zero();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
    }

    public function testUnitX(): void
    {
        $vec = Vec3::unitX();
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
    }

    public function testUnitY(): void
    {
        $vec = Vec3::unitY();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(1.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
    }

    public function testUnitZ(): void
    {
        $vec = Vec3::unitZ();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(1.0, $vec->getZ());
    }

    public function testToString(): void
    {
        $vec = new Vec3([1.0, 2.0, 3.0]);
        $this->assertEquals('(1, 2, 3)', (string)$vec);
    }

    public function testEquals(): void
    {
        $vec1 = new Vec3([1.0, 2.0, 3.0]);
        $vec2 = new Vec3([1.0, 2.0, 3.0]);
        $vec3 = new Vec3([3.0, 2.0, 1.0]);
        
        $this->assertTrue($vec1->equals($vec2));
        $this->assertFalse($vec1->equals($vec3));
    }

    public function testDistance(): void
    {
        $vec1 = new Vec3([0.0, 0.0, 0.0]);
        $vec2 = new Vec3([1.0, 2.0, 2.0]);
        $this->assertEquals(3.0, $vec1->distance($vec2));
    }
} 