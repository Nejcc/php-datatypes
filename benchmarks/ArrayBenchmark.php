<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Benchmarks;

use Nejcc\PhpDatatypes\Composite\Arrays\IntArray;
use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use Nejcc\PhpDatatypes\Composite\Dictionary;

/**
 * Benchmark comparing native PHP arrays vs PHP Datatypes arrays
 */
class ArrayBenchmark
{
    private const ITERATIONS = 10000;
    private const ARRAY_SIZE = 1000;

    public function benchmarkIntArrayCreation(): array
    {
        $data = range(1, self::ARRAY_SIZE);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $array = new IntArray($data);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'IntArray Creation'
        ];
    }

    public function benchmarkNativeArrayCreation(): array
    {
        $data = range(1, self::ARRAY_SIZE);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $array = $data;
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Native Array Creation'
        ];
    }

    public function benchmarkIntArrayOperations(): array
    {
        $data = range(1, self::ARRAY_SIZE);
        $array = new IntArray($data);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $array->toArray();
            $array->getValue();
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'IntArray Operations'
        ];
    }

    public function benchmarkNativeArrayOperations(): array
    {
        $data = range(1, self::ARRAY_SIZE);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $copy = $data;
            $count = count($data);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Native Array Operations'
        ];
    }

    public function benchmarkDictionaryOperations(): array
    {
        $data = [];
        for ($i = 0; $i < self::ARRAY_SIZE; $i++) {
            $data["key_$i"] = "value_$i";
        }
        $dict = new Dictionary($data);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $dict->toArray();
            $dict->size();
            $dict->getKeys();
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Dictionary Operations'
        ];
    }

    public function benchmarkNativeAssociativeArrayOperations(): array
    {
        $data = [];
        for ($i = 0; $i < self::ARRAY_SIZE; $i++) {
            $data["key_$i"] = "value_$i";
        }

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $copy = $data;
            $count = count($data);
            $keys = array_keys($data);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Native Associative Array Operations'
        ];
    }

    public function benchmarkIntArrayFromTrusted(): array
    {
        $data = range(1, self::ARRAY_SIZE);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $array = IntArray::fromTrusted($data);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'IntArray::fromTrusted'
        ];
    }

    public function runAllBenchmarks(): array
    {
        return [
            'int_array_creation' => $this->benchmarkIntArrayCreation(),
            'int_array_from_trusted' => $this->benchmarkIntArrayFromTrusted(),
            'native_array_creation' => $this->benchmarkNativeArrayCreation(),
            'int_array_operations' => $this->benchmarkIntArrayOperations(),
            'native_array_operations' => $this->benchmarkNativeArrayOperations(),
            'dictionary_operations' => $this->benchmarkDictionaryOperations(),
            'native_assoc_array_operations' => $this->benchmarkNativeAssociativeArrayOperations(),
        ];
    }

    public function printResults(array $results): void
    {
        echo "=== Array Benchmark Results ===\n\n";

        foreach ($results as $name => $result) {
            echo sprintf(
                "%s:\n  Time: %.6f seconds\n  Memory: %d bytes\n  Iterations: %d\n  Time per iteration: %.9f seconds\n\n",
                $result['type'],
                $result['time'],
                $result['memory'],
                $result['iterations'],
                $result['time'] / $result['iterations']
            );
        }

        // Compare IntArray vs Native
        $intArrayCreation = $results['int_array_creation'];
        $nativeArrayCreation = $results['native_array_creation'];
        $intArrayOps = $results['int_array_operations'];
        $nativeArrayOps = $results['native_array_operations'];

        echo "=== Performance Comparison ===\n";
        echo sprintf(
            "IntArray Creation vs Native: %.2fx slower\n",
            $intArrayCreation['time'] / $nativeArrayCreation['time']
        );
        echo sprintf(
            "IntArray Operations vs Native: %.2fx slower\n",
            $intArrayOps['time'] / $nativeArrayOps['time']
        );
        echo sprintf(
            "IntArray Memory overhead: %d bytes per operation\n",
            ($intArrayCreation['memory'] - $nativeArrayCreation['memory']) / $intArrayCreation['iterations']
        );
    }
}
