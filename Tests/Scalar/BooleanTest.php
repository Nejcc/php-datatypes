<?php

declare(strict_types=1);

namespace Tests\Scalar;

use Nejcc\PhpDatatypes\Scalar\Boolean;
use PHPUnit\Framework\TestCase;

final class BooleanTest extends TestCase
{
    public function testValidValues(): void
    {
        $true = new Boolean(true);
        $false = new Boolean(false);

        $this->assertTrue($true->getValue());
        $this->assertFalse($false->getValue());
    }

    public function testStringConversion(): void
    {
        $true = new Boolean(true);
        $false = new Boolean(false);

        $this->assertEquals('true', (string)$true);
        $this->assertEquals('false', (string)$false);
    }

    public function testLogicalOperations(): void
    {
        $true = new Boolean(true);
        $false = new Boolean(false);

        // AND operations
        $this->assertTrue($true->and($true)->getValue());
        $this->assertFalse($true->and($false)->getValue());
        $this->assertFalse($false->and($true)->getValue());
        $this->assertFalse($false->and($false)->getValue());

        // OR operations
        $this->assertTrue($true->or($true)->getValue());
        $this->assertTrue($true->or($false)->getValue());
        $this->assertTrue($false->or($true)->getValue());
        $this->assertFalse($false->or($false)->getValue());

        // XOR operations
        $this->assertFalse($true->xor($true)->getValue());
        $this->assertTrue($true->xor($false)->getValue());
        $this->assertTrue($false->xor($true)->getValue());
        $this->assertFalse($false->xor($false)->getValue());

        // NOT operations
        $this->assertFalse($true->not()->getValue());
        $this->assertTrue($false->not()->getValue());
    }

    public function testEquals(): void
    {
        $true = new Boolean(true);
        $false = new Boolean(false);
        $anotherTrue = new Boolean(true);
        $anotherFalse = new Boolean(false);

        $this->assertTrue($true->equals($anotherTrue));
        $this->assertTrue($false->equals($anotherFalse));
        $this->assertFalse($true->equals($false));
        $this->assertFalse($false->equals($true));
    }

    public function testFromString(): void
    {
        $this->assertTrue(Boolean::fromString('true')->getValue());
        $this->assertTrue(Boolean::fromString('TRUE')->getValue());
        $this->assertTrue(Boolean::fromString('True')->getValue());
        $this->assertFalse(Boolean::fromString('false')->getValue());
        $this->assertFalse(Boolean::fromString('FALSE')->getValue());
        $this->assertFalse(Boolean::fromString('False')->getValue());
    }

    public function testFromStringInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Boolean::fromString('invalid');
    }
}
