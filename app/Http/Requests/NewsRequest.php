<?php

namespace App\Http\Requests;

use App\Rules\alpha_num_spaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\text_size;


class NewsRequest extends FormRequest
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
        $protected_slugs = [
            'news',
        ];

        if (in_array(str_slug($this->title), $protected_slugs )){

            session()->flash('flash_message', 'Такое название зарезервированно системой, придумайте другое!');

            return redirect()
                ->back()
                ->withInput();
        }

        switch ($this->method()) {
            case 'POST':
                return [
                    'title'       => ['required', 'min:3', 'max:255'],
                    'category_id' => ['required' , Rule::notIn(['0'])],
                    'body'        => ['required', 'min:3', 'string', new text_size],
                    'img_title'   => 'required|mimes:jpeg,jpg,png',
                    'tags.*.name' => ['max:30', new alpha_num_spaces]
                ];
                break;
            case 'PUT':
                return [
                    'title'       => ['required', 'min:3', 'max:255'],
                    'category_id' => ['required' , Rule::notIn(['0'])],
                    'body'        => ['required', 'min:3', 'string', new text_size],
                    'img_title'   => 'mimes:jpeg,jpg,png',
                    'tags.*.name' => ['max:30', new alpha_num_spaces]
                ];
                break;
        }

    }
}
