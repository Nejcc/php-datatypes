<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Example form request using PHP Datatypes validation rules
 */
class PhpDatatypesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Integer validation rules
            'int8_value' => ['required', 'int8'],
            'int16_value' => ['required', 'int16'],
            'int32_value' => ['required', 'int32'],
            'int64_value' => ['required', 'int64'],
            'uint8_value' => ['required', 'uint8'],
            'uint16_value' => ['required', 'uint16'],
            'uint32_value' => ['required', 'uint32'],
            'uint64_value' => ['required', 'uint64'],
            
            // Float validation rules
            'float32_value' => ['required', 'float32'],
            'float64_value' => ['required', 'float64'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'int8_value.int8' => 'The int8_value must be a valid 8-bit signed integer (-128 to 127).',
            'int16_value.int16' => 'The int16_value must be a valid 16-bit signed integer (-32,768 to 32,767).',
            'int32_value.int32' => 'The int32_value must be a valid 32-bit signed integer.',
            'int64_value.int64' => 'The int64_value must be a valid 64-bit signed integer.',
            'uint8_value.uint8' => 'The uint8_value must be a valid 8-bit unsigned integer (0 to 255).',
            'uint16_value.uint16' => 'The uint16_value must be a valid 16-bit unsigned integer (0 to 65,535).',
            'uint32_value.uint32' => 'The uint32_value must be a valid 32-bit unsigned integer.',
            'uint64_value.uint64' => 'The uint64_value must be a valid 64-bit unsigned integer.',
            'float32_value.float32' => 'The float32_value must be a valid 32-bit floating point number.',
            'float64_value.float64' => 'The float64_value must be a valid 64-bit floating point number.',
        ];
    }
}
