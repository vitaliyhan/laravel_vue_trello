<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeskStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2'
        ];
//    return [
//            'name' => 'required|min:2|unique:desks,name,' . $this->desk->id
//        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Доска с таким именем уже есть.',
            'name.required' => 'Введите имя.',
            'name.min' => 'Название доски минимум 2 символа',
        ];

    }
}
