<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelingRequest extends FormRequest
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
            'labels.*.receiver' => ['required'],
            'labels.*.place' => ['required'],
            'labels.*.nf' => ['required'],
            'labels.*.volumes' => ['required'],
            'labels.*.size' => ['required'],
            'labels.*.quantity' => ['required']
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'labels.*.receiver.required' => 'Informe o cliente que é destinatário no Modelo Etiqueta :index.',
            'labels.*.place.required' => 'Informe o local de destino no Modelo Etiqueta :index.',
            'labels.*.nf.required' => 'Informe o número da nota fiscal no Modelo Etiqueta :index.',
            'labels.*.volumes.required' => 'Informe o número do volume descrito no Modelo Etiqueta :index.',
            'labels.*.size.required' => 'Informe o tamanho no Modelo Etiqueta :index.',
            'labels.*.quantity.required' => 'Informe a quantidade no Modelo Etiqueta :index.',
        ];
    }
}
