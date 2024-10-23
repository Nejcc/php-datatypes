<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;
use Nejcc\PhpDatatypes\Exceptions\InvalidByteException;

// Initialize variables for outputs
$examples = [];

try {
    // Example 1: Create a ByteSlice
    $fullCode1 = <<<'CODE'
<?php
use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;
use Nejcc\PhpDatatypes\Exceptions\InvalidByteException;

try {
    // Create a ByteSlice
    $byteSlice = new ByteSlice([10, 20, 255]);
    print_r($byteSlice->getValue());
} catch (InvalidByteException $e) {
    echo $e->getMessage();
}
CODE;
    ob_start();
    $byteSlice = new ByteSlice([10, 20, 255]);
    print_r($byteSlice->getValue());
    $output1 = ob_get_clean();

    $examples[] = [
        'title' => 'Create a ByteSlice',
        'description' => 'We create a <code>ByteSlice</code> with some initial byte values.',
        'code' => $fullCode1,
        'output' => $output1,
    ];

    // Example 2: Convert to Hexadecimal
    $fullCode2 = <<<'CODE'
<?php
use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;

try {
    // Create a ByteSlice
    $byteSlice = new ByteSlice([10, 20, 255]);
    $hex = $byteSlice->toHex();
    echo "Hexadecimal: " . $hex;
} catch (InvalidByteException $e) {
    echo $e->getMessage();
}
CODE;
    ob_start();
    $hex = $byteSlice->toHex();
    echo "Hexadecimal: " . $hex;
    $output2 = ob_get_clean();

    $examples[] = [
        'title' => 'Convert to Hexadecimal',
        'description' => 'We convert the byte slice to its hexadecimal representation.',
        'code' => $fullCode2,
        'output' => $output2,
    ];

    // Example 3: Slice the ByteSlice
    $fullCode3 = <<<'CODE'
<?php
use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;

try {
    // Create a ByteSlice
    $byteSlice = new ByteSlice([10, 20, 255]);
    $sliced = $byteSlice->slice(1, 2);
    print_r($sliced->getValue());
} catch (InvalidByteException $e) {
    echo $e->getMessage();
}
CODE;
    ob_start();
    $sliced = $byteSlice->slice(1, 2);
    print_r($sliced->getValue());
    $output3 = ob_get_clean();

    $examples[] = [
        'title' => 'Slice the ByteSlice',
        'description' => 'We slice a portion of the byte array, starting at index 1.',
        'code' => $fullCode3,
        'output' => $output3,
    ];

    // Example 4: Merge ByteSlices
    $fullCode4 = <<<'CODE'
<?php
use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;

try {
    // Create two ByteSlices
    $byteSlice = new ByteSlice([10, 20, 255]);
    $otherByteSlice = new ByteSlice([1, 2, 3]);

    // Merge them
    $merged = $byteSlice->merge($otherByteSlice);
    print_r($merged->getValue());
} catch (InvalidByteException $e) {
    echo $e->getMessage();
}
CODE;
    ob_start();
    $otherByteSlice = new ByteSlice([1, 2, 3]);
    $merged = $byteSlice->merge($otherByteSlice);
    print_r($merged->getValue());
    $output4 = ob_get_clean();

    $examples[] = [
        'title' => 'Merge with Another ByteSlice',
        'description' => 'We merge the current byte slice with another byte slice [1, 2, 3].',
        'code' => $fullCode4,
        'output' => $output4,
    ];

    // Example 5: Get Count of Bytes
    $fullCode5 = <<<'CODE'
<?php
use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;

try {
    // Create a ByteSlice
    $byteSlice = new ByteSlice([10, 20, 255]);

    // Get the byte count
    echo "Count of bytes: " . $byteSlice->count();
} catch (InvalidByteException $e) {
    echo $e->getMessage();
}
CODE;
    ob_start();
    echo "Count of bytes: " . $byteSlice->count();
    $output5 = ob_get_clean();

    $examples[] = [
        'title' => 'Get the Count of Bytes',
        'description' => 'We get the number of bytes currently in the byte slice.',
        'code' => $fullCode5,
        'output' => $output5,
    ];

} catch (InvalidByteException $e) {
    $errorMessage = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteSlice Example with Tailwind and Prism.js</title>

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
    <h1 class="text-3xl font-bold text-center">PHP ByteSlice Example: Step by Step</h1>
</div>

<div class="max-w-7xl mx-auto pt-20">
    <p class="text-lg mb-6 text-center">
        Below are examples demonstrating how to create, modify, and interact with a <code>ByteSlice</code> object.
        Each code block is followed by its corresponding output.
    </p>

    <!-- Loop through examples -->
    <?php foreach ($examples as $example) : ?>
        <div class="mb-8 shadow-lg rounded-lg bg-white overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2"><?php echo $example['title']; ?></h2>
                <p class="mb-4 text-gray-600"><?php echo $example['description']; ?></p>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Full Code Block -->
                    <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                        <h3 class="text-gray-300 mb-2"><i class="fas fa-code"></i> Full Code</h3>
                        <pre class="language-php"><code class="language-php"><?php echo htmlspecialchars($example['code']); ?></code></pre>
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
