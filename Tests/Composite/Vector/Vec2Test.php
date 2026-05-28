<?php

declare(strict_types=1);

namespace Tests\Composite\Vector;

use Nejcc\PhpDatatypes\Composite\Vector\Vec2;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class Vec2Test extends TestCase
{
    public function testCreateValidVec2(): void
    {
        $vec = new Vec2([1.0, 2.0]);
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(2.0, $vec->getY());
    }

    public function testCreateInvalidComponentCount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec2([1.0]);
    }

    public function testCreateWithNonNumericComponents(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Vec2(['a', 'b']);
    }

    public function testMagnitude(): void
    {
        $vec = new Vec2([3.0, 4.0]);
        $this->assertEquals(5.0, $vec->magnitude());
    }

    public function testNormalize(): void
    {
        $vec = new Vec2([3.0, 4.0]);
        $normalized = $vec->normalize();
        $this->assertEquals(1.0, $normalized->magnitude());
        $this->assertEquals(0.6, $normalized->getX());
        $this->assertEquals(0.8, $normalized->getY());
    }

    public function testNormalizeZeroVector(): void
    {
        $vec = new Vec2([0.0, 0.0]);
        $this->expectException(InvalidArgumentException::class);
        $vec->normalize();
    }

    public function testDotProduct(): void
    {
        $vec1 = new Vec2([1.0, 2.0]);
        $vec2 = new Vec2([3.0, 4.0]);
        $this->assertEquals(11.0, $vec1->dot($vec2));
    }

    public function testAdd(): void
    {
        $vec1 = new Vec2([1.0, 2.0]);
        $vec2 = new Vec2([3.0, 4.0]);
        $result = $vec1->add($vec2);
        $this->assertEquals(4.0, $result->getX());
        $this->assertEquals(6.0, $result->getY());
    }

    public function testSubtract(): void
    {
        $vec1 = new Vec2([3.0, 4.0]);
        $vec2 = new Vec2([1.0, 2.0]);
        $result = $vec1->subtract($vec2);
        $this->assertEquals(2.0, $result->getX());
        $this->assertEquals(2.0, $result->getY());
    }

    public function testScale(): void
    {
        $vec = new Vec2([1.0, 2.0]);
        $result = $vec->scale(2.0);
        $this->assertEquals(2.0, $result->getX());
        $this->assertEquals(4.0, $result->getY());
    }

    public function testCross(): void
    {
        $vec1 = new Vec2([1.0, 2.0]);
        $vec2 = new Vec2([3.0, 4.0]);
        $this->assertEquals(-2.0, $vec1->cross($vec2));
    }

    public function testZero(): void
    {
        $vec = Vec2::zero();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
    }

    public function testUnitX(): void
    {
        $vec = Vec2::unitX();
        $this->assertEquals(1.0, $vec->getX());
        $this->assertEquals(0.0, $vec->getY());
    }

    public function testUnitY(): void
    {
        $vec = Vec2::unitY();
        $this->assertEquals(0.0, $vec->getX());
        $this->assertEquals(1.0, $vec->getY());
    }

    public function testToString(): void
    {
        $vec = new Vec2([1.0, 2.0]);
        $this->assertEquals('(1, 2)', (string)$vec);
    }

    public function testEquals(): void
    {
        $vec1 = new Vec2([1.0, 2.0]);
        $vec2 = new Vec2([1.0, 2.0]);
        $vec3 = new Vec2([2.0, 1.0]);

        $this->assertTrue($vec1->equals($vec2));
        $this->assertFalse($vec1->equals($vec3));
    }

    public function testDistance(): void
    {
        $vec1 = new Vec2([0.0, 0.0]);
        $vec2 = new Vec2([3.0, 4.0]);
        $this->assertEquals(5.0, $vec1->distance($vec2));
    }
}
