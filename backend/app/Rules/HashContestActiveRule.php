<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Invite;

class HashContestActiveRule implements Rule
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
        /* Активный ли розыгрыш с таким {$value} хешем инвайта */
        $invites = Invite::where('hash', $value);
        if ($invites->exists())
        {
            $invite = $invites->first();
            return boolval($invite->contest->active);
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
        return __('validation.contest_ended');
    }
}
