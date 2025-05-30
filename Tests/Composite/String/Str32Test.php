<?php

declare(strict_types=1);

namespace Tests\Composite\String;

use Nejcc\PhpDatatypes\Composite\String\Str32;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class Str32Test extends TestCase
{
    public function testValidStr32(): void
    {
        $str = new Str32('deadbeefdeadbeefdeadbeefdeadbeef');
        $this->assertEquals('deadbeefdeadbeefdeadbeefdeadbeef', $str->getValue());
    }

    public function testInvalidLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str32 must be exactly 32 characters long');
        new Str32('deadbeefdeadbeefdeadbeefdeadbee');
    }

    public function testInvalidHex(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str32 must be a valid hex string');
        new Str32('deadbeefdeadbeefdeadbeefdeadbeeg');
    }
} 