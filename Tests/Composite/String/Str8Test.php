<?php

declare(strict_types=1);

namespace Tests\Composite\String;

use Nejcc\PhpDatatypes\Composite\String\Str8;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class Str8Test extends TestCase
{
    public function testValidStr8(): void
    {
        $str = new Str8('deadbeef');
        $this->assertEquals('deadbeef', $str->getValue());
    }

    public function testInvalidLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str8 must be exactly 8 characters long');
        new Str8('deadbee');
    }

    public function testInvalidHex(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str8 must be a valid hex string');
        new Str8('deadbeeg');
    }
} 