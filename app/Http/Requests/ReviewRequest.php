<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'text' => 'required|min:20|max:250',
            'images[].*' => 'mimes:jpg,jpeg,png,bmp,tiff',
        ];
    }

    public function attributes()
    {
        return [
            'text' => 'текст комментария',
            'images[]' => 'изображения',
        ];
    }

    public function messages()
    {
        return [
            'text.max' => 'Максимальный размер текста :max символов',
            'text.min' => 'Минимальный размер текста :min символов',

            'images[].*.mimes' => 'Разрешеные расшерения:jpg,jpeg,png,bmp,tiff',
        ];
    }
}
