<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeadquarterRequest extends FormRequest
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
                'visible' => ['required'],
                'name' => [
                    'required',
                    Rule::unique('headquarters')->ignore($this->id)
                ],
                'zip_code' => ['required', 'min:8', 'max:8'],
                'state' => ['required', 'min:2', 'max:2'],
                'city' => ['required'],
                'neighborhood' => ['required'],
                'street' => ['required'],
                'number' => ['required'],
                'telephone' => ['required'],
                'whatsapp' => ['required'],
                'map' => ['required', 'url'],
                'coordinates' => ['required'],
                'img' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048']
            ];
        } else {
            $rules = [
                'visible' => 'required',
                'name' => 'required|unique:headquarters,name',
                'zip_code' => 'required|min:8|max:8',
                'state' => 'required|min:2|max:2',
                'city' => 'required',
                'neighborhood' => 'required',
                'street' => 'required',
                'number' => 'required',
                'telephone' => 'required',
                'whatsapp' => 'required',
                'map' => 'required|url',
                'coordinates' => 'required',
                'img' => 'sometimes|image|mimes:png,jpg,jpeg,svg|max:2048'

            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'visible.required' => 'O campo Visível deve ser Sim ou Não.',
            'name.required' => 'O campo Nome da unidade é obrigatório.',
            'name.unique' => 'Este nome da unidade já está sendo utilizado.',
            'zip_code.required' => 'É necessário informar o CEP desta unidade.',
            'zip_code.min' => 'O CEP deve ser um conjunto de oito números.',
            'zip_code.max' => 'O CEP deve ser um conjunto de oito números.',
            'state.required' => 'O campo UF é obrigatório.',
            'state.min' => 'O campo UF deve ter pelo menos 2 caracteres.',
            'state.max' => 'O campo UF deve ter no máximo 2 caracteres.',
            'city.required' => 'O campo Cidade é obrigatório.',
            'neighborhood.required' => 'O campo Bairro é obrigatório.',
            'street.required' => 'O campo Rua/Avenida é obrigatório.',
            'number.required' => 'O campo Nº é obrigatório.',
            'telephone.required' => 'O campo Telefone é obrigatório.',
            'whatsapp.required' => 'O campo Celular é obrigatório.',
            'map.required' => 'O campo da localização em link é obrigatório.',
            'map.url' => 'O campo da localização em link deve ser uma URL válida.',
            'coordinates.required' => 'Insira as coordenadas de latitude e longitude as separando por vírgula. Ex: -85.4564745, -16.546665',
            'img.image' => 'O campo Imagem da fachada deve ser um arquivo de imagem.',
            'img.mimes' => 'O campo Imagem da fachada deve ser um arquivo de extensão PNG, JPG, JPEG ou SVG.',
            'img.max' => 'O campo Imagem da fachada deve ter no máximo 2 MB.'
        ];
    }
}
