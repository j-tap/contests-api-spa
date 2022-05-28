<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Contest;

class ContestActiveRule implements Rule
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
        $contest = Contest::find($value);
        if ($contest->exists())
        {
            return $contest->where('active', 1)->exists();
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
