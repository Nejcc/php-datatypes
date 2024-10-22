<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use DateTime;
use InvalidArgumentException;
use Nejcc\PhpDatatypes\Composite\Union\Union;
use PHPUnit\Framework\TestCase;
use stdClass;

class UnionTest extends TestCase
{
    /**
     * Test the constructor sets the allowed types.
     */
    public function testConstructorSetsAllowedTypes()
    {
        $union = new Union(['int', 'string']);
        $this->assertInstanceOf(Union::class, $union);
    }

    /**
     * Test that setting a valid value works.
     */
    public function testSetValueWithValidType()
    {
        $union = new Union(['int', 'string']);
        $union->setValue(123);
        $this->assertEquals(123, $union->getValue());

        $union->setValue('hello');
        $this->assertEquals('hello', $union->getValue());
    }

    /**
     * Test that setting an invalid type throws an exception.
     */
    public function testSetValueWithInvalidTypeThrowsException()
    {
        $union = new Union(['int', 'string']);

        $this->expectException(InvalidArgumentException::class);
        $union->setValue(1.5); // float is not allowed
    }

    /**
     * Test that object type validation works.
     */
    public function testSetValueWithObjectType()
    {
        $union = new Union([DateTime::class]);
        $date = new DateTime();

        $union->setValue($date);
        $this->assertEquals($date, $union->getValue());
    }

    /**
     * Test that dynamically adding allowed types works.
     */
    public function testAddAllowedType()
    {
        $union = new Union(['int']);
        $union->addAllowedType('float');

        $union->setValue(1.5);
        $this->assertEquals(1.5, $union->getValue());
    }

    /**
     * Test that isType works for scalar types.
     */
    public function testIsTypeWithScalarTypes()
    {
        $union = new Union(['int', 'string']);
        $union->setValue(123);

        $this->assertTrue($union->isType('int'));
        $this->assertFalse($union->isType('string'));
    }

    /**
     * Test that isType works for object types.
     */
    public function testIsTypeWithObjectTypes()
    {
        $union = new Union([DateTime::class]);
        $date = new DateTime();

        $union->setValue($date);
        $this->assertTrue($union->isType(DateTime::class));
    }

    /**
     * Test that validateType correctly handles invalid object types.
     */
    public function testValidateTypeThrowsExceptionForInvalidObjectType()
    {
        $union = new Union([DateTime::class]);

        $this->expectException(InvalidArgumentException::class);
        $union->setValue(new stdClass()); // stdClass is not allowed
    }
}
