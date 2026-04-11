<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
}
