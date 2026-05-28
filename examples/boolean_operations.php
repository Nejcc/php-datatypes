<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Boolean;

/**
 * Example 1: Basic Boolean Operations
 */
echo "Example 1: Basic Boolean Operations\n";
echo "==============================\n";

try {
    // Create Boolean instances
    $true = new Boolean(true);
    $false = new Boolean(false);

    echo "True value: " . ($true->getValue() ? "true" : "false") . "\n";
    echo "False value: " . ($false->getValue() ? "true" : "false") . "\n";

    // Convert to string
    echo "True as string: " . (string)$true . "\n";
    echo "False as string: " . (string)$false . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 2: Boolean Logic Operations
 */
echo "\nExample 2: Boolean Logic Operations\n";
echo "================================\n";

try {
    $true = new Boolean(true);
    $false = new Boolean(false);

    // AND operation
    echo "True AND True: " . ($true->and($true)->getValue() ? "true" : "false") . "\n";
    echo "True AND False: " . ($true->and($false)->getValue() ? "true" : "false") . "\n";
    echo "False AND False: " . ($false->and($false)->getValue() ? "true" : "false") . "\n";

    // OR operation
    echo "\nTrue OR True: " . ($true->or($true)->getValue() ? "true" : "false") . "\n";
    echo "True OR False: " . ($true->or($false)->getValue() ? "true" : "false") . "\n";
    echo "False OR False: " . ($false->or($false)->getValue() ? "true" : "false") . "\n";

    // NOT operation
    echo "\nNOT True: " . ($true->not()->getValue() ? "true" : "false") . "\n";
    echo "NOT False: " . ($false->not()->getValue() ? "true" : "false") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 3: Boolean Comparison
 */
echo "\nExample 3: Boolean Comparison\n";
echo "==========================\n";

try {
    $true1 = new Boolean(true);
    $true2 = new Boolean(true);
    $false = new Boolean(false);

    echo "Is true equal to true? " . ($true1->equals($true2) ? "Yes" : "No") . "\n";
    echo "Is true equal to false? " . ($true1->equals($false) ? "Yes" : "No") . "\n";
    echo "Is false equal to false? " . ($false->equals($false) ? "Yes" : "No") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 4: Boolean Type Conversion
 */
echo "\nExample 4: Boolean Type Conversion\n";
echo "==============================\n";

try {
    // Convert from different types
    $fromInt = Boolean::fromInt(1);
    $fromString = Boolean::fromString("true");
    $fromFloat = Boolean::fromFloat(1.0);

    echo "From integer 1: " . ($fromInt->getValue() ? "true" : "false") . "\n";
    echo "From string 'true': " . ($fromString->getValue() ? "true" : "false") . "\n";
    echo "From float 1.0: " . ($fromFloat->getValue() ? "true" : "false") . "\n";

    // Convert to different types
    $bool = new Boolean(true);
    echo "\nTo integer: " . $bool->toInt() . "\n";
    echo "To string: " . $bool->toString() . "\n";
    echo "To float: " . $bool->toFloat() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

/**
 * Example 5: Error Handling
 */
echo "\nExample 5: Error Handling\n";
echo "======================\n";

try {
    // Try to create a Boolean from invalid string
    $invalidBool = Boolean::fromString("invalid");
} catch (\InvalidArgumentException $e) {
    echo "Error creating Boolean from invalid string: " . $e->getMessage() . "\n";
}

try {
    // Try to create a Boolean from invalid integer
    $invalidInt = Boolean::fromInt(2);
} catch (\InvalidArgumentException $e) {
    echo "Error creating Boolean from invalid integer: " . $e->getMessage() . "\n";
}

/**
 * Example 6: Boolean Chain Operations
 */
echo "\nExample 6: Boolean Chain Operations\n";
echo "================================\n";

try {
    $true = new Boolean(true);
    $false = new Boolean(false);

    // Chain multiple operations
    $result1 = $true->and($false)->or($true)->not();
    echo "Chain 1 (true AND false OR true NOT): " . ($result1->getValue() ? "true" : "false") . "\n";

    $result2 = $false->or($true)->and($true)->not();
    echo "Chain 2 (false OR true AND true NOT): " . ($result2->getValue() ? "true" : "false") . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
