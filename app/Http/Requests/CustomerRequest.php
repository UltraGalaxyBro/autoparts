<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $rules = [
            'user_id' => ['required'],
            'customer_level_id' => ['required', 'integer'],
            'celphone' => ['required'],
            'type_buyer' => ['required'],
            'company' => ['required_if:type_buyer,PJ'],
            'cnpj' => ['required_if:type_buyer,PJ'],
            'ie' => ['required_if:type_buyer,PJ'],
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['cpf'] = ['nullable', 'required_if:type_buyer,PF', Rule::unique('customers')->ignore($this->id)];
        } else {
            $rules['cpf'] = ['nullable', 'required_if:type_buyer,PF', 'unique:customers,cpf'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Selecione o usuário que é categorizado como cliente.',
            'customer_level_id.required' => 'Selecione o nível do cliente.',
            'celphone.required' => 'Necessário que haja um número de celular para contato.',
            'type_buyer.required' => 'Necessário definir qual o tipo de comprador(a).',
            'cpf.required_if' => 'Caso o comprador seja do tipo Pessoa Física, é necessário informar o CPF.',
            'company.required_if' => 'Caso o comprador seja do tipo Pessoa Jurídica, é necessário informar o nome fantasia da empresa.',
            'cnpj.required_if' => 'Caso o comprador seja do tipo Pessoa Jurídica, é necessário informar o CNPJ.',
            'ie.required_if' => 'Caso o comprador seja do tipo Pessoa Jurídica, é necessário informar a Inscrição Estadual.',
        ];
    }
}
