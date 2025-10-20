<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Composite\Option;
use Nejcc\PhpDatatypes\Composite\Result;
use Nejcc\PhpDatatypes\Composite\Dictionary;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use Nejcc\PhpDatatypes\Composite\Union\UnionType;

echo "=== PHP Datatypes Comprehensive Example ===\n\n";

// 1. Scalar Types
echo "1. Scalar Types:\n";
echo "---------------\n";

$int8 = new Int8(42);
$int32 = new Int32(1000);
$uint8 = new UInt8(200);
$float32 = new Float32(3.14159);

echo "Int8: " . $int8->getValue() . "\n";
echo "Int32: " . $int32->getValue() . "\n";
echo "UInt8: " . $uint8->getValue() . "\n";
echo "Float32: " . $float32->getValue() . "\n\n";

// 2. Arithmetic Operations
echo "2. Arithmetic Operations:\n";
echo "------------------------\n";

$result = $int8->add(new Int8(10));
echo "Int8(42) + Int8(10) = " . $result->getValue() . "\n";

$result = $int32->multiply(new Int32(2));
echo "Int32(1000) * Int32(2) = " . $result->getValue() . "\n\n";

// 3. Option Type
echo "3. Option Type:\n";
echo "--------------\n";

$someValue = Option::some("Hello World");
$noneValue = Option::none();

echo "Some value: " . $someValue . "\n";
echo "None value: " . $noneValue . "\n";

$processed = $someValue
    ->map(fn($value) => strtoupper($value))
    ->unwrapOr("DEFAULT");

echo "Processed: " . $processed . "\n\n";

// 4. Result Type
echo "4. Result Type:\n";
echo "--------------\n";

$successResult = Result::ok("Operation successful");
$errorResult = Result::err("Something went wrong");

echo "Success: " . $successResult . "\n";
echo "Error: " . $errorResult . "\n";

$safeResult = Result::try(function () {
    return new Int8(50);
});

if ($safeResult->isOk()) {
    echo "Safe operation result: " . $safeResult->unwrap()->getValue() . "\n";
} else {
    echo "Safe operation failed: " . $safeResult->unwrapErr() . "\n";
}

echo "\n";

// 5. Dictionary
echo "5. Dictionary:\n";
echo "-------------\n";

$dict = new Dictionary([
    'name' => 'John Doe',
    'age' => 30,
    'email' => 'john@example.com'
]);

echo "Dictionary size: " . $dict->size() . "\n";
echo "Name: " . $dict->get('name') . "\n";
echo "Keys: " . implode(', ', $dict->getKeys()) . "\n\n";

// 6. Struct
echo "6. Struct:\n";
echo "----------\n";

$userStruct = new Struct([
    'id' => ['type' => 'int', 'nullable' => false],
    'name' => ['type' => 'string', 'nullable' => false],
    'email' => ['type' => 'string', 'nullable' => true],
], [
    'id' => 1,
    'name' => 'Jane Doe',
    'email' => 'jane@example.com'
]);

echo "User ID: " . $userStruct->get('id') . "\n";
echo "User Name: " . $userStruct->get('name') . "\n";
echo "User Email: " . $userStruct->get('email') . "\n\n";

// 7. Union Type
echo "7. Union Type:\n";
echo "-------------\n";

$union = new UnionType([
    'string' => 'string',
    'int' => 'int',
    'float' => 'float'
]);

$union->setValue('string', 'Hello Union');
echo "Union active type: " . $union->getActiveType() . "\n";
echo "Union value: " . $union->getValue() . "\n";

$union->setValue('int', 42);
echo "Union active type: " . $union->getActiveType() . "\n";
echo "Union value: " . $union->getValue() . "\n\n";

// 8. Helper Functions
echo "8. Helper Functions:\n";
echo "-------------------\n";

$int8Helper = int8(75);
$uint8Helper = uint8(150);
$float32Helper = float32(2.71828);
$someHelper = some("Helper function");
$okHelper = ok("Success");

echo "Int8 helper: " . $int8Helper->getValue() . "\n";
echo "UInt8 helper: " . $uint8Helper->getValue() . "\n";
echo "Float32 helper: " . $float32Helper->getValue() . "\n";
echo "Some helper: " . $someHelper . "\n";
echo "Ok helper: " . $okHelper . "\n\n";

// 9. Serialization
echo "9. Serialization:\n";
echo "----------------\n";

$json = $userStruct->toJson();
echo "Struct JSON: " . $json . "\n";

$xml = $userStruct->toXml();
echo "Struct XML: " . substr($xml, 0, 100) . "...\n\n";

// 10. Error Handling
echo "10. Error Handling:\n";
echo "------------------\n";

try {
    $invalidInt8 = new Int8(1000); // This will throw OutOfRangeException
} catch (\OutOfRangeException $e) {
    echo "Caught OutOfRangeException: " . $e->getMessage() . "\n";
}

try {
    $overflow = $int8->add(new Int8(100)); // This will throw OverflowException
} catch (\OverflowException $e) {
    echo "Caught OverflowException: " . $e->getMessage() . "\n";
}

echo "\n=== Example Complete ===\n";
