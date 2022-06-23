<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:50|min:5',
            'description' => 'required|max:1500',
            'price' => 'required|min:1',
            'product_type_id' => 'required',
            'images[].*' => 'required|mimes:jpg,jpeg,png,bmp,tiff',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'имя',
            'description' => 'описание',
            'price' => 'цена',
            'product_type_id' => 'категория',
            'images[]' => 'изображения',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Максимальный размер имени :max символов',
            'name.min' => 'Минимальный размер имени :min символов',

            'description.max' => 'Максимальный размер описания :max символов',

            'price.min' => 'минимальная цена 1 рубль!',

            'images[].*.mimes' => 'Разрешеные расшерения:jpg,jpeg,png,bmp,tiff',
            'images[].*.required' => 'Выберите хотябы 1 изображение',
        ];
    }
}
