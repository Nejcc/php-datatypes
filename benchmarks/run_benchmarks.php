<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Nejcc\PhpDatatypes\Benchmarks\IntegerBenchmark;
use Nejcc\PhpDatatypes\Benchmarks\ArrayBenchmark;

echo "PHP Datatypes Performance Benchmarks\n";
echo "====================================\n\n";

echo "PHP Version: " . PHP_VERSION . "\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n\n";

// Run integer benchmarks
echo "Running Integer Benchmarks...\n";
$integerBenchmark = new IntegerBenchmark();
$integerResults = $integerBenchmark->runAllBenchmarks();
$integerBenchmark->printResults($integerResults);

echo "\n" . str_repeat("=", 50) . "\n\n";

// Run array benchmarks
echo "Running Array Benchmarks...\n";
$arrayBenchmark = new ArrayBenchmark();
$arrayResults = $arrayBenchmark->runAllBenchmarks();
$arrayBenchmark->printResults($arrayResults);

echo "\n" . str_repeat("=", 50) . "\n";
echo "Benchmark completed!\n";
