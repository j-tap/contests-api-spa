<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use \Exception;

class RecaptchaRule implements Rule
{
    private static $url = 'https://www.google.com/recaptcha/api/siteverify';

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
        $data = array(
            'secret' => config('app.recaptcha_secret_key'),
            'response' => $value,
        );

        try {
            $verify = curl_init();
            curl_setopt($verify, CURLOPT_URL, $this::$url);
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($verify);
            return json_decode($response)->success;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.recaptcha');
    }
}
