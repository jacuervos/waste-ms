<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TypeWasteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'sometimes|required|string|max:100|unique:type_wastes,name,' . $this->route('typeWaste')?->id,
            'points' => 'sometimes|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'El tipo de residuo "' . $this->name . '" ya existe.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            'points.integer' => 'Los puntos deben ser un número entero.',
            'points.min' => 'Los puntos no pueden ser negativos.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Error de validación',
                'errors'  => $validator->errors(),
                'code'    => 422,
            ], 422)
        );
    }
}
