<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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

        if ($this->input('contacting') === 'Sim') {
            if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
                $rules = [
                    'name' => [
                        'required',
                        Rule::unique('suppliers')->ignore($this->id),
                    ],
                    'contacts.*.name' => ['required'],
                    'contacts.*.telephone' => ['required_without:contacts.*.celphone'],
                    'contacts.*.celphone' => ['required_without:contacts.*.telephone'],
                ];
            } else {
                $rules = [
                    'name' => 'required|unique:suppliers,name',
                    'contacts.*.name' => 'required',
                    'contacts.*.telephone' => 'required_without:contacts.*.celphone',
                    'contacts.*.celphone' => 'required_without:contacts.*.telephone',
                ];
            }
        } else {
            if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
                $rules = [
                    'name' => [
                        'required',
                        Rule::unique('suppliers')->ignore($this->id),
                    ],
                ];
            } else {
                $rules = [
                    'name' => 'required|unique:suppliers,name',
                ];
            }
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome do fornecedor é obrigatório.',
            'name.unique' => 'Já existe este fornecedor cadastrado.',
            'contacts.*.name.required' => 'Necessário informar o nome/setor das informações de contato em Informações do Contato :index.',
            'contacts.*.telephone.required_without' => 'É necessário que ao menos uma informação para ligação esteja preenchida em Informações do Contato :index, seja o telefone ou celular.',
            'contacts.*.celphone.required_without' => 'É necessário que ao menos uma informação para ligação esteja preenchida em Informações do Contato :index, seja o telefone ou celular.',
        ];
    }
}
