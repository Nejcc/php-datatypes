<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Char;

/**
 * Example 1: Basic Char Operations
 */
echo "Example 1: Basic Char Operations\n";
echo "============================\n";

try {
    // Create Char instances
    $char1 = new Char('A');
    $char2 = new Char('b');

    echo "Char 1: " . $char1->getValue() . "\n";
    echo "Char 2: " . $char2->getValue() . "\n";

    // Convert to string
    echo "Char 1 as string: " . (string)$char1 . "\n";

    // Case conversion
    echo "Char 1 to lowercase: " . $char1->toLowerCase()->getValue() . "\n";
    echo "Char 2 to uppercase: " . $char2->toUpperCase()->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: Character Type Checking
 */
echo "\nExample 2: Character Type Checking\n";
echo "==============================\n";

try {
    $letter = new Char('A');
    $digit = new Char('5');
    $symbol = new Char('@');

    echo "Is 'A' a letter? " . ($letter->isLetter() ? "Yes" : "No") . "\n";
    echo "Is 'A' uppercase? " . ($letter->isUpperCase() ? "Yes" : "No") . "\n";
    echo "Is 'A' lowercase? " . ($letter->isLowerCase() ? "Yes" : "No") . "\n";

    echo "\nIs '5' a digit? " . ($digit->isDigit() ? "Yes" : "No") . "\n";
    echo "Is '5' a letter? " . ($digit->isLetter() ? "Yes" : "No") . "\n";

    echo "\nIs '@' a letter? " . ($symbol->isLetter() ? "Yes" : "No") . "\n";
    echo "Is '@' a digit? " . ($symbol->isDigit() ? "Yes" : "No") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 3: ASCII Operations
 */
echo "\nExample 3: ASCII Operations\n";
echo "========================\n";

try {
    $char = new Char('A');

    // Get ASCII code
    $ascii = $char->toAscii();
    echo "ASCII code of 'A': " . $ascii . "\n";

    // Create Char from ASCII
    $newChar = Char::fromAscii($ascii);
    echo "Char from ASCII " . $ascii . ": " . $newChar->getValue() . "\n";

    // Try some other ASCII values
    $space = Char::fromAscii(32);
    echo "ASCII 32 (space): '" . $space->getValue() . "'\n";

    $newline = Char::fromAscii(10);
    echo "ASCII 10 (newline): '" . $newline->getValue() . "'\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 4: Character Comparison
 */
echo "\nExample 4: Character Comparison\n";
echo "===========================\n";

try {
    $char1 = new Char('A');
    $char2 = new Char('A');
    $char3 = new Char('B');

    echo "Is 'A' equal to 'A'? " . ($char1->equals($char2) ? "Yes" : "No") . "\n";
    echo "Is 'A' equal to 'B'? " . ($char1->equals($char3) ? "Yes" : "No") . "\n";

    // Compare ASCII values
    echo "ASCII of 'A': " . $char1->toAscii() . "\n";
    echo "ASCII of 'B': " . $char3->toAscii() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 5: Error Handling
 */
echo "\nExample 5: Error Handling\n";
echo "======================\n";

try {
    // Try to create a Char with multiple characters
    $invalidChar = new Char('AB');
} catch (\InvalidArgumentException $e) {
    echo "Error creating Char with multiple characters: " . $e->getMessage() . "\n";
}

try {
    // Try to create a Char from invalid ASCII
    $invalidAscii = Char::fromAscii(300);
} catch (\InvalidArgumentException $e) {
    echo "Error creating Char from invalid ASCII: " . $e->getMessage() . "\n";
}

/**
 * Example 6: Character Transformation Chain
 */
echo "\nExample 6: Character Transformation Chain\n";
echo "=====================================\n";

try {
    $char = new Char('a');

    echo "Original: " . $char->getValue() . "\n";
    echo "To uppercase: " . $char->toUpperCase()->getValue() . "\n";
    echo "Back to lowercase: " . $char->toUpperCase()->toLowerCase()->getValue() . "\n";
    echo "ASCII code: " . $char->toAscii() . "\n";
    echo "Back to char: " . Char::fromAscii($char->toAscii())->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
