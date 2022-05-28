<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Invite;

class HashActiveRule implements Rule
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
        /* Активный ли инвайт с таким {$value} хешем */
        $invites = Invite::where('hash', $value);
        if ($invites->exists())
        {
            return $invites->where('active', 1)->exists();
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.hash_not_active');
    }
}
