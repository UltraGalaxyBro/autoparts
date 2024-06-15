<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules = [
                'name' => [
                    'required',
                    Rule::unique('brands')->ignore($this->id)
                ]
            ];
        } else {
            $rules = [
                'name' => 'required|unique:brands,name',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo do nome da marca é obrigatório.',
            'name.unique' => 'Já existe esta marca cadastrada.'
        ];
    }
}
