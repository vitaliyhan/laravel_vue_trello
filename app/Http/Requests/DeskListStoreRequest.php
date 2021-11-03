<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeskListStoreRequest extends FormRequest
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
            'name' => 'required|min:1|max:255',
            'desk_id' => 'required|max:255|integer|exists:desks,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя.',
            'name.min' => 'Название доски минимум 1 символ',
        ];

    }
}
