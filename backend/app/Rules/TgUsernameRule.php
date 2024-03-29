<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Tg\TgApi;

class TgUsernameRule implements Rule
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
        $tgApi = app(TgApi::class);
        $userExist = $tgApi->existUser($value);
        return $userExist;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.telegram');
    }
}
