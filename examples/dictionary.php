<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Composite\Dictionary;

// Create a new dictionary
$dictionary = new Dictionary([
    'name' => 'John Doe',
    'age' => 30,
]);

// Add a new key-value pair
$dictionary->add('country', 'USA');

// Get a value by key
echo $dictionary->get('name'); // Output: John Doe

// Check if a key exists
if ($dictionary->containsKey('age')) {
    echo $dictionary->get('age'); // Output: 30
}

// Remove a key
$dictionary->remove('country');

// Get the size of the dictionary
echo $dictionary->size(); // Output: 2
var_dump($dictionary);
// Clear the dictionary
$dictionary->clear();

var_dump($dictionary);
