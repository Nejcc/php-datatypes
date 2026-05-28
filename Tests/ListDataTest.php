<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Tests;

use Nejcc\PhpDatatypes\Composite\ListData;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

final class ListDataTest extends TestCase
{
    public function testCanInitializeWithElements()
    {
        $list = new ListData(['Element 1', 'Element 2']);

        $this->assertEquals('Element 1', $list->get(0));
        $this->assertEquals('Element 2', $list->get(1));
    }

    public function testAddElementsToList()
    {
        $list = new ListData();
        $list->add('First element');
        $list->add(42);

        $this->assertEquals('First element', $list->get(0));
        $this->assertEquals(42, $list->get(1));
    }

    public function testRemoveElementFromList()
    {
        $list = new ListData(['Element 1', 'Element 2', 'Element 3']);

        // Remove 'Element 2'
        $list->remove(1);

        // After removal, 'Element 3' should move to index 1
        $this->assertEquals('Element 3', $list->get(1));

        // Ensure 'Element 2' no longer exists and 'Element 3' is now at the correct index
        $this->expectException(OutOfBoundsException::class);
        $list->get(2); // Trying to access index 2 should now throw an exception because there is no element at that index
    }


    public function testContainsElement()
    {
        $list = new ListData(['First', 'Second', 'Third']);

        $this->assertTrue($list->contains('First'));
        $this->assertFalse($list->contains('Fourth'));
    }

    public function testGetAllElements()
    {
        $list = new ListData(['Element 1', 'Element 2', 'Element 3']);

        $this->assertEquals(['Element 1', 'Element 2', 'Element 3'], $list->getAll());
    }

    public function testGetListSize()
    {
        $list = new ListData(['Element 1', 'Element 2']);

        $this->assertEquals(2, $list->size());

        $list->add('Element 3');
        $this->assertEquals(3, $list->size());
    }

    public function testClearList()
    {
        $list = new ListData(['Element 1', 'Element 2', 'Element 3']);
        $list->clear();

        $this->assertEquals(0, $list->size());
        $this->assertEmpty($list->getAll());
    }

    public function testGetNonExistentElementThrowsException()
    {
        $list = new ListData(['Element 1']);

        $this->expectException(OutOfBoundsException::class);
        $list->get(5); // This should throw an exception because index 5 doesn't exist
    }

    public function testRemoveNonExistentElementThrowsException()
    {
        $list = new ListData(['Element 1', 'Element 2']);

        $this->expectException(OutOfBoundsException::class);
        $list->remove(10); // This should throw an exception because index 10 doesn't exist
    }
}
