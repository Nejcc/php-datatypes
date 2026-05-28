<?php

namespace PHPSTORM_META {

    // Helper functions for PHP Datatypes
    override(\int8(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8::class,
    ]));

    override(\int16(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int16::class,
    ]));

    override(\int32(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32::class,
    ]));

    override(\int64(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int64::class,
    ]));

    override(\uint8(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8::class,
    ]));

    override(\uint16(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt16::class,
    ]));

    override(\uint32(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32::class,
    ]));

    override(\uint64(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt64::class,
    ]));

    override(\float32(0.0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32::class,
    ]));

    override(\float64(0.0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64::class,
    ]));

    override(\char(''), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Char::class,
    ]));

    override(\byte(0), map([
        '' => \Nejcc\PhpDatatypes\Scalar\Byte::class,
    ]));

    override(\some(0), map([
        '' => \Nejcc\PhpDatatypes\Composite\Option::class,
    ]));

    override(\none(), map([
        '' => \Nejcc\PhpDatatypes\Composite\Option::class,
    ]));

    override(\option(0), map([
        '' => \Nejcc\PhpDatatypes\Composite\Option::class,
    ]));

    override(\ok(0), map([
        '' => \Nejcc\PhpDatatypes\Composite\Result::class,
    ]));

    override(\err(0), map([
        '' => \Nejcc\PhpDatatypes\Composite\Result::class,
    ]));

    override(\result(function(){}), map([
        '' => \Nejcc\PhpDatatypes\Composite\Result::class,
    ]));

    override(\stringArray([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Arrays\StringArray::class,
    ]));

    override(\intArray([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Arrays\IntArray::class,
    ]));

    override(\floatArray([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Arrays\FloatArray::class,
    ]));

    override(\byteSlice([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice::class,
    ]));

    override(\listData([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\ListData::class,
    ]));

    override(\dictionary([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Dictionary::class,
    ]));

    override(\struct([]), map([
        '' => \Nejcc\PhpDatatypes\Composite\Struct\Struct::class,
    ]));

    override(\union([], []), map([
        '' => \Nejcc\PhpDatatypes\Composite\Union\UnionType::class,
    ]));
}
