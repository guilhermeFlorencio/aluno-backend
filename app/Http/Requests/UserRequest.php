<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => $this->isMethod('post') ? 'required|string|max:255' : 'sometimes|string|max:255',
            'email' => $this->isMethod('post') ? 'required|email|unique:users,email' : 'sometimes|email|unique:users,email,' . $this->route('user'),
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            'data_nascimento' => 'nullable|date',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Forneça um email válido.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'A senha é obrigatória para criação de usuários.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'data_nascimento.date' => 'Forneça uma data de nascimento válida.',
        ];
    }
}
