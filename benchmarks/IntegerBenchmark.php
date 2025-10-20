<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Benchmarks;

use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32;

/**
 * Benchmark comparing native PHP integers vs PHP Datatypes integers
 */
class IntegerBenchmark
{
    private const ITERATIONS = 100000;

    public function benchmarkInt8Creation(): array
    {
        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $int = new Int8(42);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Int8 Creation'
        ];
    }

    public function benchmarkNativeIntCreation(): array
    {
        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $int = 42;
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Native Int Creation'
        ];
    }

    public function benchmarkInt8Arithmetic(): array
    {
        $int1 = new Int8(50);
        $int2 = new Int8(30);

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $result = $int1->add($int2);
            $result = $int1->subtract($int2);
            $result = $int1->multiply($int2);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Int8 Arithmetic'
        ];
    }

    public function benchmarkNativeIntArithmetic(): array
    {
        $int1 = 50;
        $int2 = 30;

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $result = $int1 + $int2;
            $result = $int1 - $int2;
            $result = $int1 * $int2;
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS,
            'type' => 'Native Int Arithmetic'
        ];
    }

    public function benchmarkBigIntegerOperations(): array
    {
        $int1 = new Int64('9223372036854775800');
        $int2 = new Int64('7');

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        for ($i = 0; $i < self::ITERATIONS / 100; $i++) { // Fewer iterations for big ints
            $result = $int1->add($int2);
            $result = $int1->subtract($int2);
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        return [
            'time' => $end - $start,
            'memory' => $memoryEnd - $memoryStart,
            'iterations' => self::ITERATIONS / 100,
            'type' => 'Int64 Arithmetic'
        ];
    }

    public function runAllBenchmarks(): array
    {
        return [
            'int8_creation' => $this->benchmarkInt8Creation(),
            'native_int_creation' => $this->benchmarkNativeIntCreation(),
            'int8_arithmetic' => $this->benchmarkInt8Arithmetic(),
            'native_int_arithmetic' => $this->benchmarkNativeIntArithmetic(),
            'big_int_arithmetic' => $this->benchmarkBigIntegerOperations(),
        ];
    }

    public function printResults(array $results): void
    {
        echo "=== Integer Benchmark Results ===\n\n";

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

        // Compare Int8 vs Native
        $int8Creation = $results['int8_creation'];
        $nativeCreation = $results['native_int_creation'];
        $int8Arithmetic = $results['int8_arithmetic'];
        $nativeArithmetic = $results['native_int_arithmetic'];

        echo "=== Performance Comparison ===\n";
        echo sprintf(
            "Int8 Creation vs Native: %.2fx slower\n",
            $int8Creation['time'] / $nativeCreation['time']
        );
        echo sprintf(
            "Int8 Arithmetic vs Native: %.2fx slower\n",
            $int8Arithmetic['time'] / $nativeArithmetic['time']
        );
        echo sprintf(
            "Int8 Memory overhead: %d bytes per operation\n",
            ($int8Creation['memory'] - $nativeCreation['memory']) / $int8Creation['iterations']
        );
    }
}
