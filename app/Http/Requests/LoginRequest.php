<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            '_token' => 'required',
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
