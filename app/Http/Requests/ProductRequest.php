<?php

namespace App\Http\Requests;

use App\Rules\FreightCorreiosRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
                'name' => ['required'],
                'category_id' => ['required'],
                'automaker_id' => ['required'],
                'original_code' => ['required_if:original_code_null,null'],
                'brand_id' => ['required'],
                'brand_code' => ['required_if:brand_code_null,null', Rule::unique('products')->ignore($this->id)],
                'condition' => ['required'],
                'measure' => ['required'],
                'locations.*.supplier_id' => ['required', 'exists:suppliers,id'],
                'locations.*.headquarter_id' => ['required', 'exists:headquarters,id'],
                'locations.*.indoor_location' => ['required'],
                'locations.*.quantity' => ['required', 'numeric'],
                'locations.*.stock_alert_at' => ['nullable', 'numeric'],
                'cost' => ['required'],
                'price' => ['required'],
                'sale_price' => ['required_if:sale,Sim'],
                'sale_period_until' => ['required_if:sale,Sim'],
                'aplication' => ['required_if:visible,Sim'],
                'height' => ['required_if:visible,Sim'],
                'width' => ['required_if:visible,Sim'],
                'lenght' => ['required_if:visible,Sim'],
                'weight' => ['required_if:visible,Sim'],
                'freight' => ['required_if:visible,Sim', new FreightCorreiosRule],
                'packaging' => ['required_if:visible,Sim'],
                'img' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
                'img1' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
                'img2' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048']
            ];
        } else {
            $rules = [
                'name' => ['required'],
                'category_id' => ['required'],
                'automaker_id' => ['required'],
                'original_code' => ['required_unless:original_code_null,on'],
                'brand_id' => ['required'],
                'brand_code' => ['required_unless:brand_code_null,on', 'unique:products,brand_code'],
                'condition' => ['required'],
                'measure' => ['required'],
                'locations.*.supplier_id' => ['required', 'exists:suppliers,id'],
                'locations.*.headquarter_id' => ['required', 'exists:headquarters,id'],
                'locations.*.indoor_location' => ['required'],
                'locations.*.quantity' => ['required', 'numeric'],
                'locations.*.stock_alert_at' => ['nullable', 'numeric'],
                'cost' => ['required'],
                'price' => ['required'],
                'sale_price' => ['required_if:sale,Sim'],
                'sale_period_until' => ['required_if:sale,Sim'],
                'aplication' => ['required_if:visible,Sim'],
                'height' => ['required_if:visible,Sim'],
                'width' => ['required_if:visible,Sim'],
                'lenght' => ['required_if:visible,Sim'],
                'weight' => ['required_if:visible,Sim'],
                'freight' => ['required_if:visible,Sim', new FreightCorreiosRule],
                'packaging' => ['required_if:visible,Sim'],
                'img' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
                'img1' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
                'img2' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048']
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Necessário haver o nome para o produto.',
            'category_id.required' => 'Necessário haver a categoria para o produto.',
            'automaker_id.required' => 'Necessário haver a montadora para o produto.',
            'original_code.required_unless' => 'Só é permitido não preencher o código original se o mesmo sobre tal produto não existir, a montadora for GERAL e marcando que é nulo.',
            'brand_id.required' => 'Necessário haver a marca para o produto.',
            'brand_code.required_unless' => 'Só é permitido não preencher o código fabricante se o mesmo sobre tal produto não existir, a marca for GENUINE PARTS (ORIGINAL) e marcando que é nulo.',
            'condition.required' => 'Necessário haver a condição física do produto.',
            'measure.required' => 'Necessário haver o tipo de medida para o produto.',
            'locations.*.supplier_id.required' => 'Necessário informar, em Localização e Fornecimento :index, qual o fornecedor.',
            'locations.*.headquarter_id.required' => 'Necessário informar, em Localização e Fornecimento :index, a sede da empresa em que o produto está localizado.',
            'locations.*.headquarter_id.exists' => 'A sede da empresa informada para a Localização e Fornecimento :index não existe.',
            'locations.*.indoor_location.required' => 'Necessário informar, em Localização e Fornecimento :index, a localização interna do produto.',
            'locations.*.quantity.required' => 'Necessário informar, em Localização e Fornecimento :index, qual a quantidade do produto.',
            'locations.*.quantity.numeric' => 'A quantidade em Localização e Fornecimento :index deve ser um valor numérico.',
            'locations.*.stock_alert_at.numeric' => 'O alerta de estoque em Localização e Fornecimento :index deve ser um valor numérico.',
            'cost.required' => 'Necessário haver o custo do produto.',
            'price.required' => 'Necessário haver o preço do produto.',
            'sale_price.required_if' => 'Caso o produto esteja com o campo "Habilitar promoção" marcado como Sim é necessário preencher qual o valor promocional em "Promoção (R$)".',
            'sale_period_until.required_if' => 'Caso o produto esteja com o campo "Habilitar promoção" marcado como -Sim é necessário informar até quando determinada promoção estará ativa.',
            'aplication.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar a aplicação do produto.',
            'height.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar a dimensão altura.',
            'width.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar a dimensão largura.',
            'lenght.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar a dimensão comprimento.',
            'weight.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar o peso.',
            'freight.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar seu tipo de frete.',
            'packaging.required_if' => 'Caso o produto esteja com o campo visivel em site marcado como Sim é necessário informar seu tipo de embalagem para envio.',
            'img.image' => 'O campo "Imagem" deve ser um arquivo de imagem.',
            'img.mimes' => 'O campo "Imagem" deve ser um arquivo de extensão PNG, JPG, JPEG ou SVG.',
            'img.max' => 'O campo "Imagem" deve ter no máximo 2 MB.',
            'img1.image' => 'O campo "1ª imagem extra" deve ser um arquivo de imagem.',
            'img1.mimes' => 'O campo "1ª imagem extra" deve ser um arquivo de extensão PNG, JPG, JPEG ou SVG.',
            'img1.max' => 'O campo "1ª imagem extra" deve ter no máximo 2 MB.',
            'img2.image' => 'O campo "2ª imagem extra" deve ser um arquivo de imagem.',
            'img2.mimes' => 'O campo "2ª imagem extra" deve ser um arquivo de extensão PNG, JPG, JPEG ou SVG.',
            'img2.max' => 'O campo "2ª imagem extra" deve ter no máximo 2 MB.'

        ];
    }
}
