<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if ($this->input('roles') === 'Cliente') {
            if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
                    'password' => ['required_if:updatePassword,Sim', 'confirmed'],
                    'password_confirmation' => ['required_if:updatePassword,Sim'],
                    'agreed' => ['required'],
                    'roles' => ['required'],
                ];
    
                if ($this->updatePassword === 'Sim') {
                    $rules['password'][] = 'min:8';
                }
            } else {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'password' => ['required', 'min:8', 'confirmed'],
                    'password_confirmation' => ['required'],
                    'roles' => ['required'],
                ];
            }
        } else {
            if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
                    'password' => ['required_if:updatePassword,Sim', 'confirmed'],
                    'password_confirmation' => ['required_if:updatePassword,Sim'],
                    'agreed' => ['required'],
                    'roles' => ['required'],
                    'headquarter_id' => ['required'],
                ];
    
                if ($this->updatePassword === 'Sim') {
                    $rules['password'][] = 'min:8';
                }
            } else {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'password' => ['required', 'min:8', 'confirmed'],
                    'password_confirmation' => ['required'],
                    'roles' => ['required'],
                    'headquarter_id' => ['required'],
                ];
            }
        }
        

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo para nome completo é obrigatório.',
            'email.required' => 'Campo para e-mail é obrigatório.',
            'email.email' => 'Necessário que seja em formato de e-mail.',
            'email.unique' => 'Conta com este e-mail já cadastrada.',
            'password.required' => 'Campo para senha é obrigatório.',
            'password.required_if' => 'O campo de senha é necessário caso esteja marcado que irá alterar as senhas nesta edição.',
            'password.min' => 'Campo para senha deve conter ao menos 8 caracteres.',
            'password_confirmation.required' => 'Campo para confirmar senha é obrigatório.',
            'password_confirmation.required_if' => 'O campo de confirmar senha é necessário caso esteja marcado que irá alterar as senhas nesta edição.',
            'password.confirmed' => 'As senhas não conferem.',
            'agreed.required' => 'Concordar que possui consentimento em mudar os dados de usuário de quem possui esta conta é obrigatório.',
            'roles.required' => 'É obrigatório atribuir uma função para este usuário.',
            'headquarter_id.required' => 'É obrigatório atribuir um local de trabalho para este usuário que é um funcionário.',
        ];
    }
}
