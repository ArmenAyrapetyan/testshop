<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|max:30|min:2',
            'last_name' => 'required|max:30|min:2',
            'phone' => 'required|min:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'почта',
            'password' => 'пароль',
            'first_name' => 'фамилия',
            'last_name' => 'имя',
            'phone' => 'номер телефона',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Вы не заполнили поле :attribute',

            'first_name.max' => 'Вы превысили максимально число символов в поле :attribute, максимум :max',
            'first_name.min' => 'Мало символов в поле :attribute, минимум :min',

            'last_name.max' => 'Вы превысили максимально число символов в поле :attribute, максимум :max',
            'last_name.min' => 'Мало символов в поле :attribute, минимум :min',

            'phone.unique' => 'Пользователь с таким номером уже существует',

            'email.unique' => 'Пользователь с такой почтой уже существует',

            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
