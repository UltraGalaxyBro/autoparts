<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
                    Rule::unique('categories')->ignore($this->id),
                ],

                'shard_code' => [
                    'required',
                    'min:2',
                    'max:2',
                    Rule::unique('categories')->ignore($this->id),
                ],
            ];
        } else {
            $rules = [
                'name' => 'required|unique:categories,name',
                'shard_code' => 'required|max:2|min:2|unique:categories,shard_code'
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'É obrigatório preencher o campo Nome.',
            'name.unique' => 'Já existe uma categoria cadastrada com este nome.',
            'shard_code.required' => 'É obrigatório preencher o campo #.',
            'shard_code.max' => 'Por padrão o código deve conter três dígitos.',
            'shard_code.min' => 'Por padrão o código deve conter três dígitos.',
            'shard_code.unique' => 'Já existe uma categoria cadastrada com este código.',
        ];
    }
}
