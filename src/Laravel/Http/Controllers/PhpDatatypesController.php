<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Nejcc\PhpDatatypes\Laravel\Http\Requests\PhpDatatypesFormRequest;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt8;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Composite\Option;
use Nejcc\PhpDatatypes\Composite\Result;

/**
 * Example Laravel controller using PHP Datatypes
 */
class PhpDatatypesController
{
    /**
     * Example endpoint using form request validation
     */
    public function validateWithFormRequest(PhpDatatypesFormRequest $request): JsonResponse
    {
        // The request is already validated, so we can safely create datatypes
        $int8 = new Int8($request->input('int8_value'));
        $int32 = new Int32($request->input('int32_value'));
        $uint8 = new UInt8($request->input('uint8_value'));
        $float32 = new Float32($request->input('float32_value'));

        return response()->json([
            'message' => 'Validation successful',
            'data' => [
                'int8' => $int8->getValue(),
                'int32' => $int32->getValue(),
                'uint8' => $uint8->getValue(),
                'float32' => $float32->getValue(),
            ]
        ]);
    }

    /**
     * Example endpoint using manual validation
     */
    public function validateManually(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'uint8'],
            'age' => ['required', 'int8'],
            'balance' => ['required', 'float32'],
        ]);

        $userId = new UInt8($request->input('user_id'));
        $age = new Int8($request->input('age'));
        $balance = new Float32($request->input('balance'));

        return response()->json([
            'user_id' => $userId->getValue(),
            'age' => $age->getValue(),
            'balance' => $balance->getValue(),
        ]);
    }

    /**
     * Example using Option type for nullable values
     */
    public function handleOptionalData(Request $request): JsonResponse
    {
        $optionalValue = Option::fromNullable($request->input('optional_field'));

        $result = $optionalValue
            ->map(fn($value) => strtoupper($value))
            ->unwrapOr('DEFAULT_VALUE');

        return response()->json([
            'processed_value' => $result,
            'was_present' => $optionalValue->isSome(),
        ]);
    }

    /**
     * Example using Result type for error handling
     */
    public function safeOperation(Request $request): JsonResponse
    {
        $result = Result::try(function () use ($request) {
            $value = $request->input('value');
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException('Value must be numeric');
            }
            return new Int32((int) $value);
        });

        if ($result->isOk()) {
            $int32 = $result->unwrap();
            return response()->json([
                'success' => true,
                'value' => $int32->getValue(),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result->unwrapErr()->getMessage(),
        ], 400);
    }

    /**
     * Example using arithmetic operations
     */
    public function performCalculations(Request $request): JsonResponse
    {
        $request->validate([
            'a' => ['required', 'int8'],
            'b' => ['required', 'int8'],
        ]);

        $a = new Int8($request->input('a'));
        $b = new Int8($request->input('b'));

        try {
            $sum = $a->add($b);
            $difference = $a->subtract($b);
            $product = $a->multiply($b);

            return response()->json([
                'a' => $a->getValue(),
                'b' => $b->getValue(),
                'sum' => $sum->getValue(),
                'difference' => $difference->getValue(),
                'product' => $product->getValue(),
            ]);
        } catch (\OverflowException | \UnderflowException $e) {
            return response()->json([
                'error' => 'Arithmetic operation resulted in overflow or underflow',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
