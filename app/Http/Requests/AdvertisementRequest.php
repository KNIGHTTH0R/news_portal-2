<?php

namespace App\Http\Requests;

use App\Rules\alpha_num_spaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvertisementRequest extends FormRequest
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
        switch ($this->method()){

            case 'POST':
                return [
                    'seller'         => ['required', 'max:255'],
                    'text'           => ['required', 'max:255'],
                    'sale_text'      => ['required', 'max:55'],
                    'sale_title'      => ['required', 'max:55'],
                    'price'          => ['required', 'max:12'],
                    'sale_price'     => ['required', 'max:12'],
                    'block_side'     => ['required', Rule::in(['left', 'right'])],
                    'block_position' => ['required', Rule::in([1, 2, 3, 4])],
                ];
                break;

            case 'PUT':
                return [
                    'seller'         => ['required', 'max:255'],
                    'text'           => ['required', 'max:255'],
                    'sale_text'      => ['required', 'max:55'],
                    'sale_title'      => ['required', 'max:55'],
                    'price'          => ['required', 'max:12'],
                    'sale_price'     => ['required', 'max:12'],
                ];
                break;
        }

    }
}
