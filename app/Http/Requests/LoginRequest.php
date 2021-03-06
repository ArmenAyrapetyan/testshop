<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'почта',
            'password' => 'пароль',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Вы не заполнили поле :attribute',
            'password.required' => 'Вы не заполнили поле :attribute',
        ];
    }
}
