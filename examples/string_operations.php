<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\String as TypedString;

/**
 * Example 1: Basic String Operations
 */
echo "Example 1: Basic String Operations\n";
echo "==============================\n";

try {
    // Create String instances
    $str1 = new TypedString("Hello");
    $str2 = new TypedString("World");

    echo "String 1: " . $str1->getValue() . "\n";
    echo "String 2: " . $str2->getValue() . "\n";

    // String concatenation
    $concatenated = $str1->concat($str2);
    echo "Concatenated: " . $concatenated->getValue() . "\n";

    // String length
    echo "Length of String 1: " . $str1->length() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: String Case Operations
 */
echo "\nExample 2: String Case Operations\n";
echo "==============================\n";

try {
    $str = new TypedString("Hello World");

    echo "Original: " . $str->getValue() . "\n";
    echo "Uppercase: " . $str->toUpperCase()->getValue() . "\n";
    echo "Lowercase: " . $str->toLowerCase()->getValue() . "\n";
    echo "Title Case: " . $str->toTitleCase()->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 3: String Search and Replace
 */
echo "\nExample 3: String Search and Replace\n";
echo "================================\n";

try {
    $str = new TypedString("Hello World, Hello PHP");

    // Search operations
    echo "Contains 'World'? " . ($str->contains(new TypedString("World")) ? "Yes" : "No") . "\n";
    echo "Starts with 'Hello'? " . ($str->startsWith(new TypedString("Hello")) ? "Yes" : "No") . "\n";
    echo "Ends with 'PHP'? " . ($str->endsWith(new TypedString("PHP")) ? "Yes" : "No") . "\n";

    // Replace operations
    $replaced = $str->replace(new TypedString("Hello"), new TypedString("Hi"));
    echo "Replaced 'Hello' with 'Hi': " . $replaced->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 4: String Trimming and Padding
 */
echo "\nExample 4: String Trimming and Padding\n";
echo "==================================\n";

try {
    $str = new TypedString("  Hello World  ");

    echo "Original: '" . $str->getValue() . "'\n";
    echo "Trimmed: '" . $str->trim()->getValue() . "'\n";
    echo "Left Trimmed: '" . $str->trimLeft()->getValue() . "'\n";
    echo "Right Trimmed: '" . $str->trimRight()->getValue() . "'\n";

    // Padding
    $padded = $str->trim()->padLeft(15, new TypedString("*"));
    echo "Left Padded: '" . $padded->getValue() . "'\n";

    $padded = $str->trim()->padRight(15, new TypedString("*"));
    echo "Right Padded: '" . $padded->getValue() . "'\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 5: String Splitting and Joining
 */
echo "\nExample 5: String Splitting and Joining\n";
echo "===================================\n";

try {
    $str = new TypedString("Hello,World,PHP");

    // Split string
    $parts = $str->split(new TypedString(","));
    echo "Split by comma:\n";
    foreach ($parts as $part) {
        echo "- " . $part->getValue() . "\n";
    }

    // Join strings
    $joined = TypedString::join(new TypedString(" "), [
        new TypedString("Hello"),
        new TypedString("World"),
        new TypedString("PHP")
    ]);
    echo "\nJoined with space: " . $joined->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 6: String Comparison and Validation
 */
echo "\nExample 6: String Comparison and Validation\n";
echo "======================================\n";

try {
    $str1 = new TypedString("Hello");
    $str2 = new TypedString("Hello");
    $str3 = new TypedString("World");

    // Comparison
    echo "Is 'Hello' equal to 'Hello'? " . ($str1->equals($str2) ? "Yes" : "No") . "\n";
    echo "Is 'Hello' equal to 'World'? " . ($str1->equals($str3) ? "Yes" : "No") . "\n";

    // Validation
    echo "\nIs 'Hello123' alphanumeric? " . (TypedString::isAlphanumeric(new TypedString("Hello123")) ? "Yes" : "No") . "\n";
    echo "Is 'Hello123' alphabetic? " . (TypedString::isAlphabetic(new TypedString("Hello123")) ? "Yes" : "No") . "\n";
    echo "Is '123' numeric? " . (TypedString::isNumeric(new TypedString("123")) ? "Yes" : "No") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 7: String Substring and Character Access
 */
echo "\nExample 7: String Substring and Character Access\n";
echo "==========================================\n";

try {
    $str = new TypedString("Hello World");

    // Substring
    echo "Original: " . $str->getValue() . "\n";
    echo "Substring(0, 5): " . $str->substring(0, 5)->getValue() . "\n";
    echo "Substring(6): " . $str->substring(6)->getValue() . "\n";

    // Character access
    echo "\nCharacter at index 0: " . $str->charAt(0)->getValue() . "\n";
    echo "Character at index 6: " . $str->charAt(6)->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 8: String Formatting
 */
echo "\nExample 8: String Formatting\n";
echo "========================\n";

try {
    // Format with placeholders
    $formatted = TypedString::format(
        new TypedString("Hello, {0}! Welcome to {1}."),
        [new TypedString("John"), new TypedString("PHP")]
    );
    echo "Formatted: " . $formatted->getValue() . "\n";

    // Format with named placeholders
    $formatted = TypedString::formatNamed(
        new TypedString("Hello, {name}! Your age is {age}."),
        [
            "name" => new TypedString("John"),
            "age" => new TypedString("25")
        ]
    );
    echo "Formatted with names: " . $formatted->getValue() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
