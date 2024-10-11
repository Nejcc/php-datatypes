<?php
declare(strict_types=1);

use Nejcc\PhpDatatypes\Floats\Float128;
use Nejcc\PhpDatatypes\Floats\Float16;
use Nejcc\PhpDatatypes\Floats\Float8;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int128;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt16;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;

function int8(int $value): Int8
{
    return new Int8($value);
}

function int16(int $value): Int16
{
    return new Int16($value);
}

function int32(int $value): Int32
{
    return new Int32($value);
}

function int64(int $value): Int64
{
    return new Int64($value);
}

function int128(int $value): Int128
{
    return new Int128($value);
}

function uint8(int $value): UInt8
{
    return new UInt8($value);
}

function uint16(int $value): UInt16
{
    return new UInt16($value);
}

function uint32(int $value): UInt32
{
    return new UInt32($value);
}

function float32(float $value): Float32
{
    return new Float32($value);
}

function float64(float $value): Float64
{
    return new Float64($value);
}
