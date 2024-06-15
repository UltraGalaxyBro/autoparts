<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerLevelRequest extends FormRequest
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
                    Rule::unique('customer_levels')->ignore($this->id),
                ],
                'description' => [
                    'required', 'max:500'
                ],
                'discount' => [
                    'required', 'numeric'
                ]
            ];
        } else {
            $rules = [
                'name' => ['required', 'unique:customer_levels,name'],
                'description' => [
                    'required', 'max:500'
                ],
                'discount' => [
                    'required', 'numeric'
                ]
            ];
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Necessário preencher o nome/apelido único deste nível para clientes.',
            'description.required' => 'Necessário preencher o campo de descrição com no máximo 500 caracteres.',
            'description.max' => 'A descrição deve ter no máximo 500 caracteres.',
            'discount.required' => 'Necessário preencher a porcentagem do desconto deste nível para clientes.',
            'discount.numeric' => 'Formato indevido para o campo do desconto'
        ];
    }
}
