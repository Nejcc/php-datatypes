<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use Nejcc\PhpDatatypes\Exceptions\InvalidStringException;

// Initialize variables for outputs
$examples = [];

try {
    // Create a StringArray
    $stringArray = new StringArray(['apple', 'banana', 'cherry']);
    $examples[] = [
        'title' => 'Create a StringArray',
        'description' => 'We create a <code>StringArray</code> with some initial values.',
        'code' => "\$stringArray = new StringArray(['apple', 'banana', 'cherry']);",
        'output' => print_r($stringArray->getValue(), true),
    ];

    // Add new elements
    $newStringArray = $stringArray->add('date', 'elderberry');
    $examples[] = [
        'title' => 'Add New Elements',
        'description' => "We add two new elements: 'date' and 'elderberry'.",
        'code' => "\$newStringArray = \$stringArray->add('date', 'elderberry');",
        'output' => print_r($newStringArray->getValue(), true),
    ];

    // Remove 'banana'
    $modifiedArray = $newStringArray->remove('banana');
    $examples[] = [
        'title' => 'Remove an Element',
        'description' => "We remove 'banana' from the array.",
        'code' => "\$modifiedArray = \$newStringArray->remove('banana');",
        'output' => print_r($modifiedArray->getValue(), true),
    ];

    // Check if 'apple' exists
    $containsApple = $modifiedArray->contains('apple') ? "Yes" : "No";
    $examples[] = [
        'title' => "Check if 'apple' Exists",
        'description' => "We check if the array contains 'apple'.",
        'code' => "\$containsApple = \$modifiedArray->contains('apple') ? 'Yes' : 'No';",
        'output' => "Contains 'apple': " . $containsApple,
    ];

    // Convert to uppercase
    $upperCaseArray = $modifiedArray->toUpperCase();
    $examples[] = [
        'title' => 'Convert to Uppercase',
        'description' => "We convert all strings in the array to uppercase.",
        'code' => "\$upperCaseArray = \$modifiedArray->toUpperCase();",
        'output' => print_r($upperCaseArray->getValue(), true),
    ];

    // Filter by prefix 'ch'
    $filteredByPrefix = $stringArray->filterByPrefix('ch');
    $examples[] = [
        'title' => "Filter by Prefix 'ch'",
        'description' => "We filter the array to only include items starting with 'ch'.",
        'code' => "\$filteredByPrefix = \$stringArray->filterByPrefix('ch');",
        'output' => print_r($filteredByPrefix, true),
    ];

    // Filter by substring 'err'
    $filteredBySubstring = $stringArray->filterBySubstring('err');
    $examples[] = [
        'title' => "Filter by Substring 'err'",
        'description' => "We filter the array to only include items that contain 'err'.",
        'code' => "\$filteredBySubstring = \$stringArray->filterBySubstring('err');",
        'output' => print_r($filteredBySubstring, true),
    ];

    // Get count
    $count = $newStringArray->count();
    $examples[] = [
        'title' => 'Get the Count of Strings',
        'description' => "We get the number of strings currently in the array.",
        'code' => "\$count = \$newStringArray->count();",
        'output' => "Count of strings: " . $count,
    ];

    // Get string representation
    $stringRepresentation = $newStringArray->toString();
    $examples[] = [
        'title' => 'Get String Representation',
        'description' => "We convert the array to a comma-separated string.",
        'code' => "\$stringRepresentation = \$newStringArray->toString();",
        'output' => "String representation: " . $stringRepresentation,
    ];

    // Clear the array
    $clearedArray = $newStringArray->clear();
    $examples[] = [
        'title' => 'Clear the Array',
        'description' => "We clear all elements from the array.",
        'code' => "\$clearedArray = \$newStringArray->clear();",
        'output' => print_r($clearedArray->getValue(), true),
    ];

} catch (InvalidStringException $e) {
    $errorMessage = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StringArray Example with Tailwind and Prism.js</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Prism.js for Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/themes/prism.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/prism.min.js"></script>

    <!-- Additional Theme for Better Styling -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/themes/prism-tomorrow.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 p-8">

<!-- Sticky Header Section -->
<div class="">
    <h1 class="text-3xl font-bold text-center">PHP StringArray Example: Step by Step</h1>
</div>

<div class="max-w-7xl mx-auto pt-20">
    <p class="text-lg mb-6 text-center">
        Below are examples demonstrating how to create, modify, and interact with a <code>StringArray</code> object.
        Each code block is followed by its corresponding output.
    </p>

    <!-- Loop through examples -->
    <?php foreach ($examples as $example) : ?>
        <div class="mb-8 shadow-lg rounded-lg bg-white overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2"><?php echo $example['title']; ?></h2>
                <p class="mb-4 text-gray-600"><?php echo $example['description']; ?></p>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Code Block -->
                    <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                        <h3 class="text-gray-300 mb-2"><i class="fas fa-code"></i> Code</h3>
                        <code class="language-php">
                            <pre><?php echo htmlspecialchars($example['code']); ?></pre>
                        </code>
                    </div>
                    <!-- Output Block -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                        <h3 class="text-gray-700 mb-2"><i class="fas fa-terminal"></i> Output</h3>
                        <pre class="text-gray-800"><?php echo htmlspecialchars($example['output']); ?></pre>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- If there's an error -->
    <?php if (isset($errorMessage)) : ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-red-600">Error</h2>
            <p class="text-lg"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
