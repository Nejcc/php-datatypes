<?php

use Nejcc\PhpDatatypes\Integers\Signed\Int128;
use Nejcc\PhpDatatypes\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Integers\Unsigned\UInt8;

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

//
//function uint64(int $value): Int64
//{
//    return new UInt64($value);
//}
//
//function uint128(int $value): Int128
//{
//    return new UInt128($value);
//}
