<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class alpha_num_spaces implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[\d\pL\s\-]+$/u', $value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
//        return 'The :attribute may contain only letters, numbers, spaces and "-".';
        return 'Название :attribute может содержать только буквы, цифры, пробелы и дефисы.';
    }
}
