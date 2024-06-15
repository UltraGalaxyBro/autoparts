<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BudgetRequest extends FormRequest
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
                'user_id' => ['required', 'exists:users,id'],
                'customer_id' => ['required', 'exists:customers,id'],
                'validity' => ['required', 'date'],
                'payment_method' => ['required'],
                'payment_details_bol' => ['required_if:payment_method,BOLETO'],
                'payment_details_credit' => ['required_if:payment_method,CARTÃO DE CRÉDITO'],
                'freight_type' => ['required'],
                'freight_price' => Rule::requiredIf(function () {
                    return $this->freight_type == 'CIF' && !$this->freight_price_null;
                }),
                'products.*.description' => ['required'],
                'products.*.supplier_id' => ['required', 'exists:suppliers,id'],
                'products.*.cost' => ['required'],
                'products.*.deadline' => ['required', 'numeric'],
                'products.*.price' => ['required'],
                'products.*.quantity' => ['required', 'numeric'],
                'total_price' => ['required'],
            ];
        } else {
            $rules = [
                'user_id' => ['required', 'exists:users,id'],
                'customer_id' => ['required', 'exists:customers,id'],
                'validity' => ['required', 'date'],
                'payment_method' => ['required'],
                'payment_details_bol' => ['required_if:payment_method,BOLETO'],
                'payment_details_credit' => ['required_if:payment_method,CARTÃO DE CRÉDITO'],
                'freight_type' => ['required'],
                'freight_price' => Rule::requiredIf(function () {
                    return $this->freight_type == 'CIF' && !$this->freight_price_null;
                }),
                'products.*.description' => ['required'],
                'products.*.supplier_id' => ['required', 'exists:suppliers,id'],
                'products.*.cost' => ['required'],
                'products.*.deadline' => ['required', 'numeric'],
                'products.*.price' => ['required'],
                'products.*.quantity' => ['required', 'numeric'],
                'total_price' => ['required'],
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O vendedor é obrigatório.',
            'user_id.exists' => 'O vendedor deve ser um usuário válido do sistema.',
            'customer_id.required' => 'É obrigatório informar o cliente.',
            'customer_id.exists' => 'O cliente fornecido não é válido.',
            'validity.required' => 'A data de validade da cotação é obrigatória.',
            'validity.date' => 'A validade deve ser uma data válida.',
            'payment_method.required' => 'O método de pagamento é obrigatório.',
            'payment_details_bol.required_if' => 'Os detalhes de pagamento são obrigatórios quando o método de pagamento é boleto.',
            'payment_details_credit.required_if' => 'Os detalhes de pagamento são obrigatórios quando o método de pagamento é cartão de crédito.',
            'freight_type.required' => 'O tipo de frete é obrigatório.',
            'freight_price.required' => 'O valor do frete é obrigatório quando o tipo de frete é CIF e a opção -Ainda sem cálculo- não estiver marcada.',
            'products.*.description.required' => 'Você esqueceu a descrição do Produto :index.',
            'products.*.supplier_id.required' => 'Você esqueceu de informar o fornecedor do Produto :index.',
            'products.*.cost.required' => 'Você esqueceu de informar o custo do Produto :index.',
            'products.*.deadline.required' => 'Você esqueceu de informar o prazo em dias úteis em que o Produto :index estará pronto para ser despachado.',
            'products.*.deadline.numeric' => 'O prazo em dias úteis de prontidão do Produto :index deve estar de forma numérica.',
            'products.*.price.required' => 'Você esqueceu de informar o preço do Produto :index.',
            'products.*.quantity.required' => 'A quantidade do Produto :index é obrigatória.',
            'products.*.quantity.numeric' => 'A quantidade do Produto :index deve ser um valor numérico.',
            'total_price.required' => 'O preço total não está sendo calculado pois não está presente no campo oculto. Consulte o suporte sobre!'
        ];
    }
}
