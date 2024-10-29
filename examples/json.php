<?php
// json.php

declare(strict_types=1);

// Include Composer's autoloader
use Nejcc\PhpDatatypes\Composite\Json;
use Nejcc\PhpDatatypes\Encoding\HuffmanEncoding;

include_once __DIR__ . '/../vendor/autoload.php';

// Sample JSON data
$jsonData1 = '{"users":[{"id":1,"name":"Alice"},{"id":2,"name":"Bob"}]}';
$jsonData2 = '{"users":[{"id":3,"name":"Charlie"},{"id":4,"name":"Diana"}]}';

// Initialize variables for outputs
$examples = [];
$errorMessage = '';

// Start output buffering to capture print_r outputs
ob_start();

try {
    // 1. Create Json instances
    $json1 = new Json($jsonData1);
    $json2 = new Json($jsonData2);
    $examples[] = [
        'title' => 'Create Json Instances',
        'description' => 'We create two <code>Json</code> objects with different user data.',
        'code' => "\$json1 = new Json(\$jsonData1);\n\$json2 = new Json(\$jsonData2);",
        'output' => "Json1: " . $json1->getJson() . "\nJson2: " . $json2->getJson(),
    ];

//    // 2. Compare Json instances
//    $areEqual = $json1->compareWith($json2) ? 'Yes' : 'No';
//    $examples[] = [
//        'title' => 'Compare Json Instances',
//        'description' => 'We compare <code>json1</code> and <code>json2</code> to check if they are identical.',
//        'code' => "\$areEqual = \$json1->compareWith(\$json2) ? 'Yes' : 'No';",
//        'output' => "Are Json1 and Json2 identical? " . $areEqual,
//    ];

    // 3. Serialize Json to Array
    $array1 = $json1->toArray();
    $examples[] = [
        'title' => 'Serialize Json1 to Array',
        'description' => 'We convert <code>json1</code> to a PHP array.',
        'code' => "\$array1 = \$json1->toArray();",
        'output' => print_r($array1, true),
    ];

    // 4. Deserialize Array to Json
    $jsonFromArray = Json::fromArray($array1);
    $examples[] = [
        'title' => 'Deserialize Array to Json',
        'description' => 'We create a new <code>Json</code> object from <code>array1</code>.',
        'code' => "\$jsonFromArray = Json::fromArray(\$array1);",
        'output' => "Json from Array: " . $jsonFromArray->getJson(),
    ];

//    // 5. Compress Json1 using HuffmanEncoding
    $huffmanEncoder = new HuffmanEncoding();
    $compressed = $json1->compress($huffmanEncoder);
    $examples[] = [
        'title' => 'Compress Json1 using HuffmanEncoding',
        'description' => 'We compress <code>json1</code> using <code>HuffmanEncoding</code>.',
        'code' => "\$huffmanEncoder = new HuffmanEncoding();\n\$compressed = \$json1->compress(\$huffmanEncoder);",
        'output' => "Compressed Json1 (hex): " . bin2hex($compressed),
    ];

//    // 6. Decompress the previously compressed data
    $decompressedJson = $json1->decompress($huffmanEncoder, $compressed);
    $examples[] = [
        'title' => 'Decompress the Compressed Data',
        'description' => 'We decompress the previously compressed data to retrieve the original JSON.',
        'code' => "\$decompressedJson = \$json1->decompress(\$huffmanEncoder, \$compressed);",
        'output' => "Decompressed Json: " . $decompressedJson->getJson(),
    ];

    // 7. Verify decompressed data matches original
    $isMatch = ($json1->toArray() === $decompressedJson->toArray()) ? 'Yes' : 'No';
    $examples[] = [
        'title' => 'Verify Decompressed Data',
        'description' => 'We check if the decompressed JSON matches the original <code>json1</code> data.',
        'code' => "\$isMatch = (\$json1->toArray() === \$decompressedJson->toArray()) ? 'Yes' : 'No';",
        'output' => "Does decompressed Json match original Json1? " . $isMatch,
    ];
//
    // 8. Update Json1 by adding a new user
    $updatedJson1 = $json1->update('users', array_merge($json1->toArray()['users'], [['id' => 5, 'name' => 'Eve']]));
    $examples[] = [
        'title' => 'Update Json1 by Adding a New User',
        'description' => 'We add a new user to <code>json1</code>.',
        'code' => "\$updatedJson1 = \$json1->update('users', array_merge(\$json1->toArray()['users'], [['id' => 5, 'name' => 'Eve']]));",
        'output' => "Updated Json1: " . $updatedJson1->getJson(),
    ];
//
    // 9. Remove a user from updated Json1
    $modifiedJson1 = $updatedJson1->remove('users', 2); // Assuming remove method removes by 'id' or index
    $examples[] = [
        'title' => 'Remove a User from Updated Json1',
        'description' => 'We remove the user with ID 2 from <code>updatedJson1</code>.',
        'code' => "\$modifiedJson1 = \$updatedJson1->remove('users', 2);",
        'output' => "Modified Json1: " . $modifiedJson1->getJson(),
    ];

} catch (InvalidArgumentException|JsonException $e) {
    $errorMessage = $e->getMessage();
}

// Capture all outputs
$content = ob_get_clean();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Json Class Test Example</title>

    <!-- TailwindCSS CDN for Styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Prism.js for Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/themes/prism.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/components/prism-php.min.js"></script>
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-7xl mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">Json Class Test Example</h1>

    <?php if (!empty($errorMessage)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline"><?php echo htmlspecialchars($errorMessage); ?></span>
        </div>
    <?php endif; ?>

    <?php foreach ($examples as $example) : ?>
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="px-6 py-4">
                <h2 class="text-2xl font-semibold mb-2"><?php echo htmlspecialchars($example['title']); ?></h2>
                <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($example['description']); ?></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Code Block -->
                    <div>
                        <h3 class="text-xl font-medium mb-2">Code</h3>
                        <pre class="language-php bg-gray-800 text-white p-4 rounded"><code class="language-php"><?php echo htmlspecialchars($example['code']); ?></code></pre>
                    </div>
                    <!-- Output Block -->
                    <div>
                        <h3 class="text-xl font-medium mb-2">Output</h3>
                        <pre class="bg-gray-100 text-gray-800 p-4 rounded"><?php echo htmlspecialchars($example['output']); ?></pre>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
