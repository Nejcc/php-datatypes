<?php

declare(strict_types=1);

use Nejcc\PhpDatatypes\Composite\Struct\Struct;

include_once __DIR__ . '/../vendor/autoload.php';


// example 1
$struct = new Struct([
    'name' => 'string',
    'age' => '?int',
    'balance' => 'float',
]);

$struct->set('name', 'Nejc');  // Sets name to 'Nejc'
$struct->set('age', null);     // Allows nullable int
$struct->set('balance', 100.50); // Sets balance to 100.50

echo $struct->get('name');    // Outputs 'Nejc'
echo $struct->get('age');     // Outputs null
echo $struct->get('balance'); // Outputs 100.50

// Using magic methods
$struct->name = 'John'; // Equivalent to $struct->set('name', 'John');
echo $struct->name; // Equivalent to $struct->get('name');

var_dump($struct);


//example 2

$struct2 = struct([
    'name' => 'string',
    'age' => '?int',
    'balance' => 'float',
]);

$struct2->set('name', 'Test');  // Sets name to 'Nejc'
$struct2->set('age', null);     // Allows nullable int
$struct2->set('balance', 100.50); // Sets balance to 100.50

echo $struct2->get('name');    // Outputs 'Nejc'
echo $struct2->get('age');     // Outputs null
echo $struct2->get('balance'); // Outputs 100.50

// Using magic methods
$struct2->name = 'John'; // Equivalent to $struct2->set('name', 'John');
echo $struct2->name; // Equivalent to $struct2->get('name');

var_dump($struct);
