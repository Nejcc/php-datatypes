<?php
declare(strict_types=1);

use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;
use Nejcc\PhpDatatypes\Composite\Arrays\FloatArray;
use Nejcc\PhpDatatypes\Composite\Arrays\IntArray;
use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use Nejcc\PhpDatatypes\Composite\Dictionary;
use Nejcc\PhpDatatypes\Composite\ListData;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use Nejcc\PhpDatatypes\Scalar\Byte;
use Nejcc\PhpDatatypes\Scalar\Char;
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

/**
 * @param int $value
 * @return Int8
 */
function int8(int $value): Int8
{
    return new Int8($value);
}

/**
 * @param int $value
 * @return Int16
 */
function int16(int $value): Int16
{
    return new Int16($value);
}

/**
 * @param int $value
 * @return Int32
 */
function int32(int $value): Int32
{
    return new Int32($value);
}

/**
 * @param int $value
 * @return Int64
 */
function int64(int $value): Int64
{
    return new Int64($value);
}

/**
 * @param int $value
 * @return Int128
 */
function int128(int $value): Int128
{
    return new Int128($value);
}

/**
 * @param int $value
 * @return UInt8
 */
function uint8(int $value): UInt8
{
    return new UInt8($value);
}

/**
 * @param int $value
 * @return UInt16
 */
function uint16(int $value): UInt16
{
    return new UInt16($value);
}

/**
 * @param int $value
 * @return UInt32
 */
function uint32(int $value): UInt32
{
    return new UInt32($value);
}

/**
 * @param float $value
 * @return Float32
 */
function float32(float $value): Float32
{
    return new Float32($value);
}

/**
 * @param float $value
 * @return Float64
 */
function float64(float $value): Float64
{
    return new Float64($value);
}

function char(string $value): Char
{
    return new Char($value);
}

function byte(string|int $value): Byte
{
    return new Byte($value);
}

function stringArray(array $value): StringArray
{
    return new StringArray($value);
}

function intArray(array $value): IntArray
{
    return new IntArray($value);
}

function floatArray(array $value): FloatArray
{
    return new FloatArray($value);
}

function byteSlice(array $value): ByteSlice
{
    return new ByteSlice($value);
}

function listData(array $value): ListData
{
    return new ListData($value);
}

function dictionary(array $value): Dictionary
{
    return new Dictionary($value);
}

function struct(array $fields): Struct
{
    return new Struct($fields);
}

