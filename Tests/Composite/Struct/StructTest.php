<?php

declare(strict_types=1);

namespace Tests\Composite\Struct;

use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class StructTest extends TestCase
{
    public function testBasicStruct(): void
    {
        $schema = [
            'id' => ['type' => 'int', 'default' => 0],
            'name' => ['type' => 'string', 'nullable' => false],
            'email' => ['type' => 'string', 'nullable' => true],
        ];
        $struct = new Struct($schema, ['name' => 'Alice']);
        $this->assertEquals(0, $struct->get('id'));
        $this->assertEquals('Alice', $struct->get('name'));
        $this->assertNull($struct->get('email'));
    }

    public function testRequiredFieldMissing(): void
    {
        $schema = [
            'name' => ['type' => 'string', 'nullable' => false],
        ];
        $this->expectException(InvalidArgumentException::class);
        new Struct($schema, []);
    }

    public function testFieldValidation(): void
    {
        $schema = [
            'email' => [
                'type' => 'string',
                'rules' => [fn($v) => filter_var($v, FILTER_VALIDATE_EMAIL)],
            ],
        ];
        $this->expectException(ValidationException::class);
        new Struct($schema, ['email' => 'invalid-email']);
    }

    public function testNestedStruct(): void
    {
        $schema = [
            'profile' => ['type' => Struct::class, 'nullable' => true],
        ];
        $nestedSchema = [
            'name' => ['type' => 'string'],
        ];
        $nestedStruct = new Struct($nestedSchema, ['name' => 'Bob']);
        $struct = new Struct($schema, ['profile' => $nestedStruct]);
        $this->assertInstanceOf(Struct::class, $struct->get('profile'));
        $this->assertEquals('Bob', $struct->get('profile')->get('name'));
    }

    public function testToArray(): void
    {
        $schema = [
            'id' => ['type' => 'int', 'default' => 0],
            'name' => ['type' => 'string', 'alias' => 'userName'],
        ];
        $struct = new Struct($schema, ['name' => 'Alice']);
        $arr = $struct->toArray(true);
        $this->assertEquals(['id' => 0, 'userName' => 'Alice'], $arr);
    }

    public function testFromArray(): void
    {
        $schema = [
            'id' => ['type' => 'int'],
            'name' => ['type' => 'string'],
        ];
        $struct = Struct::fromArray($schema, ['id' => 1, 'name' => 'Alice']);
        $this->assertEquals(1, $struct->get('id'));
        $this->assertEquals('Alice', $struct->get('name'));
    }

    public function testToJson(): void
    {
        $schema = [
            'id' => ['type' => 'int', 'default' => 0],
            'name' => ['type' => 'string', 'alias' => 'userName'],
        ];
        $struct = new Struct($schema, ['name' => 'Alice']);
        $json = $struct->toJson(true);
        $this->assertEquals('{"id":0,"userName":"Alice"}', $json);
    }

    public function testFromJson(): void
    {
        $schema = [
            'id' => ['type' => 'int'],
            'name' => ['type' => 'string'],
        ];
        $struct = Struct::fromJson($schema, '{"id":1,"name":"Alice"}');
        $this->assertEquals(1, $struct->get('id'));
        $this->assertEquals('Alice', $struct->get('name'));
    }

    public function testToXml(): void
    {
        $schema = [
            'id' => ['type' => 'int', 'default' => 0],
            'name' => ['type' => 'string', 'alias' => 'userName'],
        ];
        $struct = new Struct($schema, ['name' => 'Alice']);
        $xml = $struct->toXml(true);
        $this->assertStringContainsString('<userName>Alice</userName>', $xml);
    }

    public function testFromXml(): void
    {
        $schema = [
            'id' => ['type' => 'int'],
            'name' => ['type' => 'string'],
        ];
        $struct = Struct::fromXml($schema, '<struct><id>1</id><name>Alice</name></struct>');
        $this->assertEquals(1, $struct->get('id'));
        $this->assertEquals('Alice', $struct->get('name'));
    }
} 