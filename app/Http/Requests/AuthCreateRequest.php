<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthCreateRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'agreed' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo para nome completo é obrigatório.',
            'email.required' => 'Campo para e-mail é obrigatório.',
            'email.email' => 'Necessário que seja em formato de e-mail.',
            'email.unique' => 'Conta com este e-mail já cadastrada.',
            'password.required' => 'Campo para senha é obrigatório.',
            'password.min' => 'Campo para senha deve conter ao menos 8 caracteres.',
            'password_confirmation.required' => 'Campo para confirmar senha é obrigatório.',
            'password.confirmed' => 'As senhas não conferem.',
            'agreed.required' => 'Concordar que leu e aceita as diretrizes é obrigatório.',

        ];
    }
}
