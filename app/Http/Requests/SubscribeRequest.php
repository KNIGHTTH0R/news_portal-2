<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
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
            'email' => 'required|email|unique:subscribe',
        ];
    }

    public function messages()
    {
       return [
           'name.required' => 'Поле обязательно для заполнения',
           'name.max' => 'Максимальная длина 255 символов',
           'email.required' => 'Поле обязательно для заполнения',
           'email.email' => 'Поле должно быть в формате электронной почты',
           'email.unique' => 'Такой email уже исползуется, введите другой',
       ];
    }
}
