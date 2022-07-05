<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeRequest extends FormRequest
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
            'name' => 'required|unique:product_types,name'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'название типа'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле название должно быть заполнено',
            'name.unique' => 'Такой тип уже существует',
        ];
    }
}
