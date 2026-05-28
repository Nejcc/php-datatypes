<?php

declare(strict_types=1);

namespace Tests\Composite\String;

use Nejcc\PhpDatatypes\Composite\String\Str16;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class Str16Test extends TestCase
{
    public function testValidStr16(): void
    {
        $str = new Str16('deadbeefdeadbeef');
        $this->assertEquals('deadbeefdeadbeef', $str->getValue());
    }

    public function testInvalidLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str16 must be exactly 16 characters long');
        new Str16('deadbeefdeadbee');
    }

    public function testInvalidHex(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Str16 must be a valid hex string');
        new Str16('deadbeefdeadbeeg');
    }
} 