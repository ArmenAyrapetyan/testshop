<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'phone' => 'required|min:11',
            'email' => 'required|email',
            'avatar' => 'max:10000|mimes:jpg,jpeg,png,bmp,tiff',
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
            'avatar' => 'изображение профиля',
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

            'avatar.max' => 'Максимальный размер изображения 10 мегабит',
            'avatar.mimes' => 'Разрешеные расшерения:jpg,jpeg,png,bmp,tiff',
        ];
    }
}
