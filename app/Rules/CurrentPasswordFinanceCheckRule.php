<?php



namespace App\Rules;



use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Validation\Rule;



class CurrentPasswordFinanceCheckRule implements Rule

{

    /**

     * Determine if the validation rule passes.

     *

     * @param  string  $attribute

     * @param  mixed  $value

     * @return bool

     */

    public function passes($attribute, $value)

    {

        return Hash::check($value, auth()->user()->password_finance);

    }



    /**

     * Get the validation error message.

     *

     * @return string

     */

    public function message()

    {

        return __('O campo de senha financeira atual não corresponde à sua senha');

    }

}

