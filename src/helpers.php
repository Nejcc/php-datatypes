<?php

use Nejcc\PhpDatatypes\Integers\Signed\Int128;
use Nejcc\PhpDatatypes\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Integers\Signed\Int8;

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
