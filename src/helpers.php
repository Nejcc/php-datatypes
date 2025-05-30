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
use Nejcc\PhpDatatypes\Composite\Union\UnionType;

if (!function_exists('int8')) {
    /**
     * @param int $value
     *
     * @return Int8
     */
    function int8(int $value): Int8
    {
        return new Int8($value);
    }
}

if (!function_exists('int16')) {
    /**
     * @param int $value
     *
     * @return Int16
     */
    function int16(int $value): Int16
    {
        return new Int16($value);
    }
}

if (!function_exists('int32')) {
    /**
     * @param int $value
     *
     * @return Int32
     */
    function int32(int $value): Int32
    {
        return new Int32($value);
    }
}

if (!function_exists('int64')) {
    /**
     * @param int $value
     *
     * @return Int64
     */
    function int64(int $value): Int64
    {
        return new Int64($value);
    }
}

if (!function_exists('int128')) {
    /**
     * @param int $value
     *
     * @return Int128
     */
    function int128(int $value): Int128
    {
        return new Int128($value);
    }
}

if (!function_exists('uint8')) {
    /**
     * @param int $value
     *
     * @return UInt8
     */
    function uint8(int $value): UInt8
    {
        return new UInt8($value);
    }
}

if (!function_exists('uint16')) {
    /**
     * @param int $value
     *
     * @return UInt16
     */
    function uint16(int $value): UInt16
    {
        return new UInt16($value);
    }
}

if (!function_exists('uint32')) {
    /**
     * @param int $value
     *
     * @return UInt32
     */
    function uint32(int $value): UInt32
    {
        return new UInt32($value);
    }
}

if (!function_exists('float32')) {
    /**
     * @param float $value
     *
     * @return Float32
     */
    function float32(float $value): Float32
    {
        return new Float32($value);
    }
}

if (!function_exists('float64')) {
    /**
     * @param float $value
     *
     * @return Float64
     */
    function float64(float $value): Float64
    {
        return new Float64($value);
    }
}

if (!function_exists('char')) {
    function char(string $value): Char
    {
        return new Char($value);
    }
}

if (!function_exists('byte')) {
    function byte(string|int $value): Byte
    {
        return new Byte($value);
    }
}

if (!function_exists('stringArray')) {
    function stringArray(array $value): StringArray
    {
        return new StringArray($value);
    }
}

if (!function_exists('intArray')) {
    function intArray(array $value): IntArray
    {
        return new IntArray($value);
    }
}

if (!function_exists('floatArray')) {
    function floatArray(array $value): FloatArray
    {
        return new FloatArray($value);
    }
}

if (!function_exists('byteSlice')) {
    function byteSlice(array $value): ByteSlice
    {
        return new ByteSlice($value);
    }
}

if (!function_exists('listData')) {
    function listData(array $value): ListData
    {
        return new ListData($value);
    }
}

if (!function_exists('dictionary')) {
    function dictionary(array $value): Dictionary
    {
        return new Dictionary($value);
    }
}

if (!function_exists('struct')) {
    function struct(array $fields): Struct
    {
        return new Struct($fields);
    }
}

if (!function_exists('union')) {
    function union(array $typeMap, array $initialValues = []): UnionType
    {
        return new UnionType($typeMap, $initialValues);
    }
}

if (!function_exists('toUnion')) {
    function toUnion(UnionType $union): array
    {
        return [
            'activeType' => $union->getActiveType(),
            'value' => $union->getValue()
        ];
    }
}

if (!function_exists('fromUnion')) {
    function fromUnion(array $data): UnionType
    {
        if (!isset($data['activeType']) || !isset($data['value'])) {
            throw new InvalidArgumentException('Invalid union data format');
        }
        $union = new UnionType([$data['activeType'] => $data['activeType']]);
        if ($data['activeType'] !== null) {
            $union->setValue($data['activeType'], $data['value']);
        }
        return $union;
    }
}

// --- Serialization/Deserialization Helpers ---

// StringArray
if (!function_exists('toJsonStringArray')) {
    function toJsonStringArray(StringArray $arr): string { return json_encode($arr->toArray()); }
}
if (!function_exists('fromJsonStringArray')) {
    function fromJsonStringArray(string $json): StringArray { return new StringArray(json_decode($json, true)); }
}

// IntArray
if (!function_exists('toJsonIntArray')) {
    function toJsonIntArray(IntArray $arr): string { return json_encode($arr->toArray()); }
}
if (!function_exists('fromJsonIntArray')) {
    function fromJsonIntArray(string $json): IntArray { return new IntArray(json_decode($json, true)); }
}

// FloatArray
if (!function_exists('toJsonFloatArray')) {
    function toJsonFloatArray(FloatArray $arr): string { return json_encode($arr->toArray()); }
}
if (!function_exists('fromJsonFloatArray')) {
    function fromJsonFloatArray(string $json): FloatArray { return new FloatArray(json_decode($json, true)); }
}

// ByteSlice
if (!function_exists('toJsonByteSlice')) {
    function toJsonByteSlice(ByteSlice $arr): string { return json_encode($arr->toArray()); }
}
if (!function_exists('fromJsonByteSlice')) {
    function fromJsonByteSlice(string $json): ByteSlice { return new ByteSlice(json_decode($json, true)); }
}

// Struct
if (!function_exists('toJsonStruct')) {
    function toJsonStruct(Struct $struct): string { return json_encode($struct->toArray()); }
}
if (!function_exists('fromJsonStruct')) {
    function fromJsonStruct(string $json): Struct { return new Struct(json_decode($json, true)); }
}

// Dictionary
if (!function_exists('toJsonDictionary')) {
    function toJsonDictionary(Dictionary $dict): string { return json_encode($dict->toArray()); }
}
if (!function_exists('fromJsonDictionary')) {
    function fromJsonDictionary(string $json): Dictionary { return new Dictionary(json_decode($json, true)); }
}

// ListData
if (!function_exists('toJsonListData')) {
    function toJsonListData(ListData $list): string { return json_encode($list->toArray()); }
}
if (!function_exists('fromJsonListData')) {
    function fromJsonListData(string $json): ListData { return new ListData(json_decode($json, true)); }
}

// UnionType (already present for JSON, XML, Binary)
if (!function_exists('unionToJson')) {
    function unionToJson(UnionType $union): string { return $union->toJson(); }
}
if (!function_exists('unionFromJson')) {
    function unionFromJson(string $json): UnionType { return UnionType::fromJson($json); }
}
if (!function_exists('unionToXml')) {
    function unionToXml(UnionType $union, ?string $namespaceUri = null, ?string $prefix = null): string { return $union->toXml($namespaceUri, $prefix); }
}
if (!function_exists('unionFromXml')) {
    function unionFromXml(string $xml): UnionType { return UnionType::fromXml($xml); }
}
if (!function_exists('unionToBinary')) {
    function unionToBinary(UnionType $union): string { return $union->toBinary(); }
}
if (!function_exists('unionFromBinary')) {
    function unionFromBinary(string $binary): UnionType { return UnionType::fromBinary($binary); }
}

// --- XML and Binary Serialization/Deserialization Helpers ---

// StringArray
if (!function_exists('toXmlStringArray')) {
    function toXmlStringArray(StringArray $arr): string {
        $xml = new SimpleXMLElement('<StringArray></StringArray>');
        foreach ($arr->toArray() as $item) {
            $xml->addChild('item', htmlspecialchars((string)$item));
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlStringArray')) {
    function fromXmlStringArray(string $xml): StringArray {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $arr[] = (string)$item;
            }
        }
        return new StringArray($arr);
    }
}
if (!function_exists('toBinaryStringArray')) {
    function toBinaryStringArray(StringArray $arr): string { return serialize($arr->toArray()); }
}
if (!function_exists('fromBinaryStringArray')) {
    function fromBinaryStringArray(string $bin): StringArray { return new StringArray(unserialize($bin)); }
}

// IntArray
if (!function_exists('toXmlIntArray')) {
    function toXmlIntArray(IntArray $arr): string {
        $xml = new SimpleXMLElement('<IntArray></IntArray>');
        foreach ($arr->toArray() as $item) {
            $xml->addChild('item', (string)$item);
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlIntArray')) {
    function fromXmlIntArray(string $xml): IntArray {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $arr[] = (int)$item;
            }
        }
        return new IntArray($arr);
    }
}
if (!function_exists('toBinaryIntArray')) {
    function toBinaryIntArray(IntArray $arr): string { return serialize($arr->toArray()); }
}
if (!function_exists('fromBinaryIntArray')) {
    function fromBinaryIntArray(string $bin): IntArray { return new IntArray(unserialize($bin)); }
}

// FloatArray
if (!function_exists('toXmlFloatArray')) {
    function toXmlFloatArray(FloatArray $arr): string {
        $xml = new SimpleXMLElement('<FloatArray></FloatArray>');
        foreach ($arr->toArray() as $item) {
            $xml->addChild('item', (string)$item);
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlFloatArray')) {
    function fromXmlFloatArray(string $xml): FloatArray {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $arr[] = (float)$item;
            }
        }
        return new FloatArray($arr);
    }
}
if (!function_exists('toBinaryFloatArray')) {
    function toBinaryFloatArray(FloatArray $arr): string { return serialize($arr->toArray()); }
}
if (!function_exists('fromBinaryFloatArray')) {
    function fromBinaryFloatArray(string $bin): FloatArray { return new FloatArray(unserialize($bin)); }
}

// ByteSlice
if (!function_exists('toXmlByteSlice')) {
    function toXmlByteSlice(ByteSlice $arr): string {
        $xml = new SimpleXMLElement('<ByteSlice></ByteSlice>');
        foreach ($arr->toArray() as $item) {
            $xml->addChild('item', (string)$item);
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlByteSlice')) {
    function fromXmlByteSlice(string $xml): ByteSlice {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $arr[] = (int)$item;
            }
        }
        return new ByteSlice($arr);
    }
}
if (!function_exists('toBinaryByteSlice')) {
    function toBinaryByteSlice(ByteSlice $arr): string { return serialize($arr->toArray()); }
}
if (!function_exists('fromBinaryByteSlice')) {
    function fromBinaryByteSlice(string $bin): ByteSlice { return new ByteSlice(unserialize($bin)); }
}

// Struct
if (!function_exists('toXmlStruct')) {
    function toXmlStruct(Struct $struct): string {
        $xml = new SimpleXMLElement('<Struct></Struct>');
        foreach ($struct->toArray() as $key => $value) {
            $xml->addChild($key, htmlspecialchars((string)$value));
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlStruct')) {
    function fromXmlStruct(string $xml): Struct {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false) {
            foreach ($data as $key => $value) {
                $arr[$key] = (string)$value;
            }
        }
        return new Struct($arr);
    }
}
if (!function_exists('toBinaryStruct')) {
    function toBinaryStruct(Struct $struct): string { return serialize($struct->toArray()); }
}
if (!function_exists('fromBinaryStruct')) {
    function fromBinaryStruct(string $bin): Struct { return new Struct(unserialize($bin)); }
}

// Dictionary
if (!function_exists('toXmlDictionary')) {
    function toXmlDictionary(Dictionary $dict): string {
        $xml = new SimpleXMLElement('<Dictionary></Dictionary>');
        foreach ($dict->toArray() as $key => $value) {
            $item = $xml->addChild('item');
            $item->addChild('key', htmlspecialchars((string)$key));
            $item->addChild('value', htmlspecialchars((string)$value));
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlDictionary')) {
    function fromXmlDictionary(string $xml): Dictionary {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $k = isset($item->key) ? (string)$item->key : null;
                $v = isset($item->value) ? (string)$item->value : null;
                if ($k !== null) $arr[$k] = $v;
            }
        }
        return new Dictionary($arr);
    }
}
if (!function_exists('toBinaryDictionary')) {
    function toBinaryDictionary(Dictionary $dict): string { return serialize($dict->toArray()); }
}
if (!function_exists('fromBinaryDictionary')) {
    function fromBinaryDictionary(string $bin): Dictionary { return new Dictionary(unserialize($bin)); }
}

// ListData
if (!function_exists('toXmlListData')) {
    function toXmlListData(ListData $list): string {
        $xml = new SimpleXMLElement('<ListData></ListData>');
        foreach ($list->toArray() as $item) {
            $xml->addChild('item', htmlspecialchars((string)$item));
        }
        return $xml->asXML();
    }
}
if (!function_exists('fromXmlListData')) {
    function fromXmlListData(string $xml): ListData {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false && isset($data->item)) {
            foreach ($data->item as $item) {
                $arr[] = (string)$item;
            }
        }
        return new ListData($arr);
    }
}
if (!function_exists('toBinaryListData')) {
    function toBinaryListData(ListData $list): string { return serialize($list->toArray()); }
}
if (!function_exists('fromBinaryListData')) {
    function fromBinaryListData(string $bin): ListData { return new ListData(unserialize($bin)); }
}
