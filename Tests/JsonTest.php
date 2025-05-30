<?php

declare(strict_types=1);

use Nejcc\PhpDatatypes\Composite\Json;
use Nejcc\PhpDatatypes\Interfaces\EncoderInterface;
use Nejcc\PhpDatatypes\Interfaces\DecoderInterface;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    public function testValidJsonConstruction(): void
    {
        $json = new Json('{"a":1,"b":2}');
        $this->assertSame('{"a":1,"b":2}', $json->getJson());
    }

    public function testInvalidJsonThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Json('{invalid json}');
    }

    public function testToArrayAndToObject(): void
    {
        $json = new Json('{"a":1,"b":2}');
        $this->assertSame(['a' => 1, 'b' => 2], $json->toArray());
        $obj = $json->toObject();
        $this->assertIsObject($obj);
        $this->assertEquals(1, $obj->a);
        $this->assertEquals(2, $obj->b);
    }

    public function testFromArrayAndFromObject(): void
    {
        $arr = ['x' => 10, 'y' => 20];
        $json = Json::fromArray($arr);
        $this->assertSame($arr, $json->toArray());

        $obj = (object)['foo' => 'bar'];
        $json2 = Json::fromObject($obj);
        $this->assertSame(['foo' => 'bar'], $json2->toArray());
    }

    public function testCompressAndDecompress(): void
    {
        $json = new Json('{"a":1}');
        $encoder = new class implements EncoderInterface {
            public function encode(string $data): string { return base64_encode($data); }
        };
        $decoder = new class implements DecoderInterface {
            public function decode(string $data): string { return base64_decode($data); }
        };
        $compressed = $json->compress($encoder);
        $this->assertSame(base64_encode('{"a":1}'), $compressed);
        $decompressed = Json::decompress($decoder, $compressed);
        $this->assertSame(['a' => 1], $decompressed->toArray());
    }

    public function testMerge(): void
    {
        $json1 = new Json('{"a":1,"b":2}');
        $json2 = new Json('{"b":3,"c":4}');
        $merged = $json1->merge($json2);
        $this->assertSame(['a' => 1, 'b' => [2, 3], 'c' => 4], $merged->toArray());
    }

    public function testUpdateAndRemove(): void
    {
        $json = new Json('{"a":1,"b":2}');
        $updated = $json->update('b', 99);
        $this->assertSame(['a' => 1, 'b' => 99], $updated->toArray());
        $removed = $updated->remove('a');
        $this->assertSame(['b' => 99], $removed->toArray());
    }

    public function testFromArrayInvalid(): void
    {
        $this->expectException(JsonException::class);
        Json::fromArray(["bad" => fopen('php://memory', 'r')]);
    }
} 