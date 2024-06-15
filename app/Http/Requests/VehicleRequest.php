<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
                'type' => [
                    'required'
                ],
                'name' => [
                    'required'
                ],
                'license_plate' => [
                    'required',
                    Rule::unique('vehicles')->ignore($this->id)
                ]
            ];
        } else {
            $rules = [
                'type' => 'required',
                'name' => 'required',
                'license_plate' => 'required|unique:vehicles,license_plate',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Informe o tipo do veículo.',
            'name.required' => 'É necessário informar algum nome ou modelo do veículo para reconhecê-lo.',
            'license_plate.required' => 'É obrigatório informar a placa do veículo.',
            'license_plate.unique' => 'Já existe veículo com esta placa cadastrado no sistema.'
        ];
    }
}
