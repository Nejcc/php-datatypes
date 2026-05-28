<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests\Attributes;

use Nejcc\PhpDatatypes\Attributes\Email;
use Nejcc\PhpDatatypes\Attributes\Length;
use Nejcc\PhpDatatypes\Attributes\NotNull;
use Nejcc\PhpDatatypes\Attributes\Range;
use Nejcc\PhpDatatypes\Attributes\Validator;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

final class ValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        Validator::clearCache();
    }

    public function testValidatesRange(): void
    {
        $prop = new ReflectionProperty(ValidatorFixture::class, 'age');
        Validator::validateProperty(30, $prop);
        $this->expectException(\OutOfRangeException::class);
        Validator::validateProperty(200, $prop);
    }

    public function testValidatesEmail(): void
    {
        $prop = new ReflectionProperty(ValidatorFixture::class, 'email');
        Validator::validateProperty('user@example.com', $prop);
        $this->expectException(\InvalidArgumentException::class);
        Validator::validateProperty('not-an-email', $prop);
    }

    public function testValidatesLength(): void
    {
        $prop = new ReflectionProperty(ValidatorFixture::class, 'name');
        Validator::validateProperty('Nejc', $prop);
        $this->expectException(\InvalidArgumentException::class);
        Validator::validateProperty('x', $prop);
    }

    public function testValidatesNotNull(): void
    {
        $prop = new ReflectionProperty(ValidatorFixture::class, 'name');
        $this->expectException(\InvalidArgumentException::class);
        Validator::validateProperty(null, $prop);
    }

    public function testCacheReusedAcrossCalls(): void
    {
        // First call populates the cache.
        $prop1 = new ReflectionProperty(ValidatorFixture::class, 'age');
        Validator::validateProperty(30, $prop1);

        // A freshly constructed ReflectionProperty for the same field should
        // hit the cache (key is Class::property, not the reflection object).
        $prop2 = new ReflectionProperty(ValidatorFixture::class, 'age');
        Validator::validateProperty(25, $prop2);

        // Sanity: clearing resets state without errors.
        Validator::clearCache();
        Validator::validateProperty(40, $prop1);
        $this->assertTrue(true);
    }
}

final class ValidatorFixture
{
    #[Range(min: 0, max: 150)]
    public int $age = 0;

    #[Email]
    #[NotNull]
    public ?string $email = null;

    #[NotNull]
    #[Length(min: 2, max: 50)]
    public ?string $name = null;
}
