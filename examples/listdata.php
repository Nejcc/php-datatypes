<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Composite\ListData;

$list = new ListData();

// Add elements to the list
$list->add('First element');
$list->add(42);
$list->add(['nested', 'array']);

// Retrieve an element by index
echo $list->get(0); // Output: First element

// Remove an element by index
$list->remove(1);

// Check if the list contains a specific element
if ($list->contains('First element')) {
    echo "Element exists!";
}

// Get the entire list
print_r($list->getAll()); // Output: Array containing remaining elements

// Get the size of the list
echo $list->size(); // Output: 2
var_dump($list);

// Clear the list
$list->clear();
echo $list->size(); // Output: 0 (empty list)

var_dump($list);
