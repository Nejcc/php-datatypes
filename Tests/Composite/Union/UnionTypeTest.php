<?php

declare(strict_types=1);

namespace Tests\Composite\Union;

use Nejcc\PhpDatatypes\Composite\Union\UnionType;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;
use PHPUnit\Framework\TestCase;

final class UnionTypeTest extends TestCase
{
    public function testBasicUnionType(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->assertEquals(['string', 'int'], $union->getTypes());
        $this->expectException(InvalidArgumentException::class);
        $union->getActiveType();
    }

    public function testEmptyUnionType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Union type must have at least one possible type');

        new UnionType([]);
    }

    public function testSetAndGetValue(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->setValue('string', 'world');
        $this->assertEquals('string', $union->getActiveType());
        $this->assertEquals('world', $union->getValue());

        $union->setValue('int', 100);
        $this->assertEquals('int', $union->getActiveType());
        $this->assertEquals(100, $union->getValue());
    }

    public function testInvalidType(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Type key 'float' is not valid in this union");

        $union->setValue('float', 3.14);
    }

    public function testGetValueWithoutActiveType(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('No type is currently active');

        $union->getValue();
    }

    public function testIsType(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->assertFalse($union->isType('string'));
        $this->assertFalse($union->isType('int'));

        $union->setValue('string', 'world');
        $this->assertTrue($union->isType('string'));
        $this->assertFalse($union->isType('int'));
    }

    public function testPatternMatching(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->setValue('string', 'world');

        $result = $union->match([
            'string' => fn($value) => "String: $value",
            'int' => fn($value) => "Integer: $value"
        ]);

        $this->assertEquals('String: world', $result);
    }

    public function testPatternMatchingWithDefault(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->setValue('string', 'world');

        $result = $union->matchWithDefault(
            [
                'int' => fn($value) => "Integer: $value"
            ],
            fn() => 'Default case'
        );

        $this->assertEquals('Default case', $result);
    }

    public function testPatternMatchingWithoutMatch(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->setValue('string', 'world');

        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage("No pattern defined for type 'string'");

        $union->match([
            'int' => fn($value) => "Integer: $value"
        ]);
    }

    public function testToString(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->assertEquals('UnionType<uninitialized>', (string)$union);

        $union->setValue('string', 'world');
        $this->assertEquals('UnionType<string>', (string)$union);
    }

    public function testComplexPatternMatching(): void
    {
        $union = new UnionType([
            'success' => 'array',
            'error' => 'array',
            'loading' => 'null'
        ]);

        $union->setValue('success', ['data' => 'operation completed']);

        $result = $union->match([
            'success' => fn($value) => "Success: {$value['data']}",
            'error' => fn($value) => "Error: {$value['message']}",
            'loading' => fn() => 'Loading...'
        ]);

        $this->assertEquals('Success: operation completed', $result);
    }

    public function testAddType(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->addType('float', 'float', 3.14);
        $this->assertContains('float', $union->getTypes());

        $union->setValue('float', 2.718);
        $this->assertEquals('float', $union->getActiveType());
        $this->assertEquals(2.718, $union->getValue());
    }

    public function testAddExistingType(): void
    {
        $union = new UnionType([
            'string' => 'string'
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Type key 'string' already exists in this union");

        $union->addType('string', 'string', 'world');
    }

    public function testTypeValidation(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for key 'string': expected 'string', got 'integer'");

        $union->setValue('string', 123);
    }

    public function testClassInstanceType(): void
    {
        class_exists('DateTime') || class_alias(\DateTime::class, 'DateTime');
        
        $union = new UnionType([
            'DateTime' => 'DateTime'
        ]);

        $union->setValue('DateTime', new \DateTime());
        $this->assertTrue($union->isType('DateTime'));
    }

    public function testTypeMapping(): void
    {
        $union = new UnionType([
            'int' => 'int',
            'float' => 'float',
            'bool' => 'bool'
        ]);

        $union->setValue('int', 100);
        $this->assertTrue($union->isType('int'));

        $union->setValue('float', 2.718);
        $this->assertTrue($union->isType('float'));

        $union->setValue('bool', false);
        $this->assertTrue($union->isType('bool'));
    }

    public function testComplexTypeValidation(): void
    {
        $union = new UnionType([
            'array' => 'array',
            'object' => 'object'
        ]);

        $union->setValue('array', ['a', 'b', 'c']);
        $this->assertTrue($union->isType('array'));

        $union->setValue('object', new \stdClass());
        $this->assertTrue($union->isType('object'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for key 'array': expected 'array', got 'string'");
        $union->setValue('array', 'not an array');
    }

    public function testNullValueHandling(): void
    {
        $union = new UnionType([
            'string' => 'string',
            'int' => 'int'
        ]);

        $union->setValue('string', null);
        $this->assertTrue($union->isType('string'));
        $this->assertNull($union->getValue());

        $union->setValue('int', null);
        $this->assertTrue($union->isType('int'));
        $this->assertNull($union->getValue());
    }

    public function testGetActiveType(): void
    {
        $union = new UnionType(['int' => 'int', 'string' => 'string']);
        $union->setValue('int', 42);
        $this->assertSame('int', $union->getActiveType());

        $union = new UnionType(['int' => 'int', 'string' => 'string']);
        $this->expectException(InvalidArgumentException::class);
        $union->getActiveType();
    }

    public function testSafeTypeCasting(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $union->setValue('string', 'hello');
        $this->assertSame('hello', $union->castTo('string'));
        $this->expectException(TypeMismatchException::class);
        $union->castTo('int');
    }

    public function testSafeTypeCastingNoActiveType(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $this->expectException(TypeMismatchException::class);
        $union->castTo('string');
    }

    public function testEquals(): void
    {
        $union1 = new UnionType(['string' => 'string', 'int' => 'int']);
        $union2 = new UnionType(['string' => 'string', 'int' => 'int']);
        $union3 = new UnionType(['string' => 'string', 'int' => 'int']);

        $union1->setValue('string', 'hello');
        $union2->setValue('string', 'hello');
        $union3->setValue('int', 100);

        $this->assertTrue($union1->equals($union2));
        $this->assertFalse($union1->equals($union3));
    }

    public function testEqualsNoActiveType(): void
    {
        $union1 = new UnionType(['string' => 'string', 'int' => 'int']);
        $union2 = new UnionType(['string' => 'string', 'int' => 'int']);
        $this->assertFalse($union1->equals($union2));
    }

    public function testJsonSerialization(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $union->setValue('string', 'hello');
        $json = $union->toJson();
        $this->assertJson($json);
        $this->assertStringContainsString('"activeType":"string"', $json);
        $this->assertStringContainsString('"value":"hello"', $json);

        $reconstructed = UnionType::fromJson($json);
        $this->assertTrue($union->equals($reconstructed));
    }

    public function testJsonDeserializationInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid JSON format for UnionType');
        UnionType::fromJson('{"invalid": "format"}');
    }

    public function testXmlSerialization(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $union->setValue('string', 'hello');
        $xml = $union->toXml();
        $this->assertStringContainsString('<union', $xml);
        $this->assertStringContainsString('activeType="string"', $xml);
        $this->assertStringContainsString('<value>hello</value>', $xml);

        $reconstructed = UnionType::fromXml($xml);
        $this->assertTrue($union->equals($reconstructed));
    }

    public function testXmlDeserializationInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid XML format for UnionType');
        UnionType::fromXml('<invalid>format</invalid>');
    }

    public function testValidateXmlSchemaValid(): void
    {
        $xml = '<?xml version="1.0"?><union activeType="string"><value>hello</value></union>';
        $xsd = '<?xml version="1.0"?>
        <xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
          <xs:element name="union">
            <xs:complexType>
              <xs:sequence>
                <xs:element name="value" type="xs:string" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="activeType" type="xs:string" use="required"/>
            </xs:complexType>
          </xs:element>
        </xs:schema>';
        $this->assertTrue(UnionType::validateXmlSchema($xml, $xsd));
    }

    public function testValidateXmlSchemaInvalid(): void
    {
        $xml = '<?xml version="1.0"?><union><value>hello</value></union>';
        $xsd = '<?xml version="1.0"?>
        <xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
          <xs:element name="union">
            <xs:complexType>
              <xs:sequence>
                <xs:element name="value" type="xs:string" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="activeType" type="xs:string" use="required"/>
            </xs:complexType>
          </xs:element>
        </xs:schema>';
        $this->expectException(InvalidArgumentException::class);
        UnionType::validateXmlSchema($xml, $xsd);
    }

    public function testXmlNamespaceSerialization(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $union->setValue('string', 'hello');
        $namespace = 'http://example.com/union';
        $prefix = 'u';
        $xml = $union->toXml($namespace, $prefix);
        $this->assertStringContainsString('xmlns:u="http://example.com/union"', $xml);
        $this->assertStringContainsString('<u:union', $xml);
        $this->assertStringContainsString('<u:value>hello</u:value>', $xml);
        $reconstructed = UnionType::fromXml($xml);
        $this->assertTrue($union->equals($reconstructed));
    }

    public function testXmlNamespaceDeserialization(): void
    {
        $xml = '<?xml version="1.0"?>
        <u:union xmlns:u="http://example.com/union" activeType="string">
            <u:value>hello</u:value>
        </u:union>';
        $union = UnionType::fromXml($xml);
        $this->assertEquals('string', $union->getActiveType());
        $this->assertEquals('hello', $union->getValue());
    }

    public function testBinarySerialization(): void
    {
        $union = new UnionType(['string' => 'string', 'int' => 'int']);
        $union->setValue('string', 'hello');
        $binary = $union->toBinary();
        $reconstructed = UnionType::fromBinary($binary);
        $this->assertTrue($union->equals($reconstructed));
    }

    public function testBinaryDeserializationInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid binary format for UnionType');
        UnionType::fromBinary('invalid binary data');
    }
} 