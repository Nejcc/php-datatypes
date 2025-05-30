<?php

declare(strict_types=1);

namespace Tests\Composite\Vector;

use Nejcc\PhpDatatypes\Composite\Vector\Vec4;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class Vec4Test extends TestCase
{
    public function testCreateValidVec4(): void
    {
        $vec = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(2.0, $vec->getY());
        $this->assertEquals(3.0, $vec->getZ());
        $this->assertEquals(4.0, $vec->getW());
    }

    public function testCreateInvalidComponentCount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec4([1.0, 2.0, 3.0]);
    }

    public function testCreateWithNonNumericComponents(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec4(['a', 'b', 'c', 'd']);
    }

    public function testMagnitude(): void
    {
        $vec = new Vec4([1.0, 2.0, 2.0, 2.0]);
        $this->assertEquals(sqrt(13), $vec->magnitude());
    }

    public function testNormalize(): void
    {
        $vec = new Vec4([1.0, 2.0, 2.0, 2.0]);
        $normalized = $vec->normalize();
        $this->assertEquals(1.0, $normalized->magnitude());
        $this->assertEquals(1 / sqrt(13), $normalized->getX());
        $this->assertEquals(2 / sqrt(13), $normalized->getY());
        $this->assertEquals(2 / sqrt(13), $normalized->getZ());
        $this->assertEquals(2 / sqrt(13), $normalized->getW());
    }

    public function testNormalizeZeroVector(): void
    {
        $vec = new Vec4([0.0, 0.0, 0.0, 0.0]);
        $this->expectException(InvalidArgumentException::class);
        $vec->normalize();
    }

    public function testDotProduct(): void
    {
        $vec1 = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $vec2 = new Vec4([5.0, 6.0, 7.0, 8.0]);
        $this->assertEquals(70.0, $vec1->dot($vec2));
    }

    public function testAdd(): void
    {
        $vec1 = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $vec2 = new Vec4([5.0, 6.0, 7.0, 8.0]);
        $result = $vec1->add($vec2);
        $this->assertEquals(6.0, $result->getX());
        $this->assertEquals(8.0, $result->getY());
        $this->assertEquals(10.0, $result->getZ());
        $this->assertEquals(12.0, $result->getW());
    }

    public function testSubtract(): void
    {
        $vec1 = new Vec4([5.0, 6.0, 7.0, 8.0]);
        $vec2 = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $result = $vec1->subtract($vec2);
        $this->assertEquals(4.0, $result->getX());
        $this->assertEquals(4.0, $result->getY());
        $this->assertEquals(4.0, $result->getZ());
        $this->assertEquals(4.0, $result->getW());
    }

    public function testScale(): void
    {
        $vec = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $result = $vec->scale(2.0);
        $this->assertEquals(2.0, $result->getX());
        $this->assertEquals(4.0, $result->getY());
        $this->assertEquals(6.0, $result->getZ());
        $this->assertEquals(8.0, $result->getW());
    }

    public function testZero(): void
    {
        $vec = Vec4::zero();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
        $this->assertEquals(0.0, $vec->getW());
    }

    public function testUnitX(): void
    {
        $vec = Vec4::unitX();
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
        $this->assertEquals(0.0, $vec->getW());
    }

    public function testUnitY(): void
    {
        $vec = Vec4::unitY();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(1.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
        $this->assertEquals(0.0, $vec->getW());
    }

    public function testUnitZ(): void
    {
        $vec = Vec4::unitZ();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(1.0, $vec->getZ());
        $this->assertEquals(0.0, $vec->getW());
    }

    public function testUnitW(): void
    {
        $vec = Vec4::unitW();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
        $this->assertEquals(0.0, $vec->getZ());
        $this->assertEquals(1.0, $vec->getW());
    }

    public function testToString(): void
    {
        $vec = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $this->assertEquals('(1, 2, 3, 4)', (string)$vec);
    }

    public function testEquals(): void
    {
        $vec1 = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $vec2 = new Vec4([1.0, 2.0, 3.0, 4.0]);
        $vec3 = new Vec4([4.0, 3.0, 2.0, 1.0]);

        $this->assertTrue($vec1->equals($vec2));
        $this->assertFalse($vec1->equals($vec3));
    }

    public function testDistance(): void
    {
        $vec1 = new Vec4([0.0, 0.0, 0.0, 0.0]);
        $vec2 = new Vec4([1.0, 2.0, 2.0, 2.0]);
        $this->assertEquals(sqrt(13), $vec1->distance($vec2));
    }
}
